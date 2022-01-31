<!-- Extends template page -->
@extends('app')

@section('title', 'Walmart Order List')

<!-- Specify content -->
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(Session::has('message'))
                            <div class="alert {{ Session::get('alert-class') }}">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <div class="card-header">
                            <a class='btn btn-sm btn-primary float-right' href="{{route('dashboard.shipping_performance')}}">Walmart Order For Shipping Performance</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PurchaseID</th>
                                    <th>CustomerID</th>
                                    <th>Order Date</th>
                                    <th>Delivery Date</th>
                                    <th>Ship Date</th>
                                    <th>Country</th>
                                    <th>Ship Program Type</th>
                                </tr>
                                </thead>
                                <tbody>

                                @php
                                    $index=1;
                                @endphp

                                @if(count($walmart_orders)>0)
                                    @foreach($walmart_orders as $walmart_orders)

                                        <tr>
                                            <td><strong>{{ $index }}</strong></td>
                                            <td>{{ $walmart_orders['purchaseOrderId'] }}</td>
                                            <td>{{ $walmart_orders['customerOrderId'] }}</td>
                                            <td>{{ $walmart_orders['order_date'] }}</td>
                                            <td>{{ $walmart_orders['estimatedDeliveryDate'] }}</td>
                                            <td>{{ $walmart_orders['estimatedShipDate'] }}</td>
                                            <td>{{ $walmart_orders['country'] }}</td>
                                            <td>{{ $walmart_orders['shippingProgramType'] }}</td>

                                        </tr>

                                        @php
                                            $index++ ;
                                        @endphp

                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center"><h2>No Records Found!</h2></td>
                                    </tr>
                                @endif





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





@stop


<script src="{{ asset('js/global/global.min.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>--}}
{{--<script src="https://checkout.stripe.com/checkout.js"></script>--}}
{{--<script type="text/javascript">--}}
{{--    function pay(amount) {--}}
{{--        //alert(amount)--}}
{{--        var handler = StripeCheckout.configure({--}}
{{--            key: 'pk_test_4WnfGlBdGN57LeBNFQ66jWRK00tKLQeKAg', // your publisher key id--}}
{{--            locale: 'auto',--}}
{{--            token: function (token) {--}}
{{--                // You can access the token ID with `token.id`.--}}
{{--                // Get the token ID to your server-side code for use.--}}
{{--                console.log('Token Created!!');--}}
{{--                console.log(token);--}}
{{--                //alert('Token Created!!');--}}

{{--                //alert(JSON.stringify(token,null,4));--}}

{{--                //$('#token_response').html(JSON.stringify(token));--}}
{{--                $.ajax({--}}
{{--                    url:'{{ route("subscription_post") }}',--}}
{{--                    method: 'post',--}}
{{--                    data: {--}}
{{--                        tokenId: token.id,--}}
{{--                        amount: amount,--}}
{{--                        "_token": "{{ csrf_token() }}"--}}
{{--                    },--}}
{{--                    // dataType: "json",--}}
{{--                    success: function( response ) {--}}

{{--                        $("#successModel").modal("show");--}}
{{--                        //alert("response")--}}
{{--                        //alert(response);--}}
{{--                        console.log(response.data);--}}
{{--                        //$('#token_response').append( '<br />' + JSON.stringify(response.data));--}}
{{--                    }--}}
{{--                })--}}
{{--            }--}}
{{--        });--}}
{{--        handler.open({--}}
{{--            name: 'Wally',--}}
{{--            email: 'seller@gmail.com',--}}
{{--            description: 'Subscription',--}}
{{--            amount: amount * 100,--}}
{{--            image: "https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png",--}}
{{--        });--}}
{{--    }--}}
{{--</script>--}}
