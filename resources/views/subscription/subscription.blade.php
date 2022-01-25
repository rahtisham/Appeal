<!-- Extends template page-->
@extends('app')

@section('title', 'Subscription Plans')

<!-- Specify content -->
@section('content')

<section class="content">
    <div class="container-fluid">
    	<div class="row">
			@foreach($subscription as $subscriptions)
    			<div class="col-md-4">
      				<div class="card card-pricing text-center px-3 mb-4">
            			<div class="bg-transparent card-header border-0 d-block">
			                <h2 class="font-weight-normal text-primary text-center" data-pricing-value="15">{{$subscriptions->price}}</h2>
			                <h3 class="dollar_txt">{{$subscriptions->month}} Month</h3>
			                <h6 class="">Basic</h6>
			            </div>
            			<div class="card-body pt-0">
			                <ul class="list-unstyled mb-4">
			                    <li>{{$subscriptions->description}}</li>
			                    <li>Basic support on Github</li>
			                    <li>Monthly updates</li>
			                    <li>Free cancelation</li>
			                    <li>Sed sed diam porta, interdum risus nec</li>
			                </ul>
			                <button class="btn btn-outline-secondary" onclick="pay('{{$subscriptions->price}}','{{$subscriptions->description}}','{{$subscriptions->month}}')">Choose Plan</button>
			            </div>
			        </div>
			    </div>
			@endforeach
    	</div>
	</div>
</section>

<div class="modal fade" id="successModel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="https://openjournalsystems.com/file/2017/07/payment-success.png" class="mx-auto" width="100" height="100">
        <h5 class="text-green">Payment Successfully Done</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" >&times;</span>
        </button>
      </div>
      
      
    </div>
</div>
@stop

<script src="{{ asset('js/global/global.min.js') }}"></script> 
<script src="{{ asset('js/custom.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript">
function pay(amount,description,months) {
	//alert(description)
var handler = StripeCheckout.configure({
		key: 'pk_test_4WnfGlBdGN57LeBNFQ66jWRK00tKLQeKAg', // your publisher key id
		locale: 'auto',
		token: function (token) {
		// You can access the token ID with `token.id`.
		// Get the token ID to your server-side code for use.
		console.log('Token Created!!');
		console.log(token);
		//alert('Token Created!!');

					//alert(JSON.stringify(token,null,4));

		//$('#token_response').html(JSON.stringify(token));
			$.ajax({
			url:'{{ route("subscription_post") }}',
			method: 'post',
			data: { 
				tokenId: token.id, 
				amount: amount, 
				months: months, 
				description : description,
				"_token": "{{ csrf_token() }}"
			},
			// dataType: "json",
				success: function( response ) {

                    $("#successModel").modal("show");
					//alert("response")
					//alert(response);
					console.log(response.data);
					//$('#token_response').append( '<br />' + JSON.stringify(response.data));
				}
			})
		}
});
	handler.open({
		name: 'Wally',
        email: 'seller@gmail.com',
		description: 'Subscription',
		amount: amount * 100,
		image: "https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png",
		});
	}
</script>
