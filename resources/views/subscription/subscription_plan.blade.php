<!-- Extends template page-->
@extends('app')

@section('title', 'Subscription Plans')

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
                    <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#exampleModal_add" data-whatever="@mdo">Add Subscription</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>PRICE</th>
                        <th>MONTH</th>
                        <th>DESCRIPTION</th>
                        <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $index=1;
                        @endphp
                        @foreach($subscription_plans as $subscriptions)
                            
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $subscriptions->price }}</td>
                                <td>{{ $subscriptions->month }}</td>
                                <td>{{ $subscriptions->description }}</td>
                                <td>
                                   <!-- Edit -->
                                   <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-price="{{ $subscriptions->price }}" data-month="{{ $subscriptions->month }}" data-description="{{ $subscriptions->description }}" data-id="{{ $subscriptions->id }}">Edit</a>
                                   <!-- Delete -->
                                   <a href="javascript:void(0);" class="btn btn-sm btn-danger" data-id="{{ $subscriptions->id }}">Delete</a>
                                </td>
                            </tr>
                            @php
                                $index++ ;
                            @endphp
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>

<!-- Edit Subscription pop-up  start -->

<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subscription Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="alert alert-danger" style="display:none"></div>

      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="price" class="col-form-label">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="">
          </div>
          <div class="form-group">
            <select class="form-select form-control" aria-label="Default select example" name="month" id="month">
                <option value="" selected>Month</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <div>
              <input type="hidden" value="" name="update_id" id="update_id">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editSubscriptionPlan">Edit</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Subscription pop-up  end -->


<!-- Add Subscription pop-up  start -->

<div class="modal fade" id="exampleModal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_add" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel_add">Add Subscription Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="alert alert-danger" style="display:none"></div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="add_price" class="col-form-label">Price:</label>
            <input type="text" name="add_price" class="form-control" id="add_price" value="">
          </div>
          <div class="form-group">
            <select class="form-select form-control" aria-label="Default select example" name="add_month" id="add_month">
                <option value="" selected>Month</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Description:</label>
            <textarea class="form-control" name="add_description" id="add_description"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="ajaxSubmit">Add Subscription</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Subscription pop-up  end -->


<!-- Delete pop-up start -->

<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to Delete this Record</p>
        <input type="hidden" name="" value="" id="id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary deleteData" data-yes="1">Yes</button>
      </div>
    </div>
  </div>
</div>

@stop
<!-- Delete pop-up end -->

<!-- Add subscripion script start -->
@push('scripts')
 <script>
     jQuery(document).ready(function(){
        jQuery('#ajaxSubmit').click(function(e){

           e.preventDefault();
           $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
          });
           jQuery.ajax({
              url: "{{ route('subscription_plan.store') }}",
              method: 'post',
              data: {
                 price: jQuery('#add_price').val(),
                 month: jQuery('#add_month').val(),
                 description: jQuery('#add_description').val(),
                 "_token": "{{ csrf_token() }}"
              },
              success: function(result){
                //alert(JSON.stringify(result,null,4))
                if(result.errors)
                {
                    jQuery('.alert-danger').html('');

                    jQuery.each(result.errors, function(key, value){
                        jQuery('.alert-danger').show();
                        jQuery('.alert-danger').append('<li>'+value+'</li>');
                    });
                }
                else
                {
                    jQuery('.alert-danger').hide();
                    $('#open').hide();
                    $('#exampleModal_add').modal('hide');

                     var url ="{{ route('subscription_plan.index') }}"; //the url I want to redirect to
                        $(location).attr('href', url);
                        //location.reload();
                }
              }});
           });
        });

     setTimeout(function () {
        $('#alert').alert('close');
    }, 5000);

  </script>

<!-- Add subscripion script end -->



<!-- Delete subscripion script start -->

  <script type="text/javascript">

         $(".deleteRecord").click(function(){
            id = $(this).data("id");
            $("#id").val(id);
            $("#deleteModel").modal("show");
        });

         $(".deleteData").click(function(){
            var id= $("#id").val();
            var token = $("meta[name='csrf-token']").attr("content");
            var destroy_url = '{{ route("subscription_plan.destroy", ":id") }}';
                route_url = destroy_url.replace(':id', id);
        
            $.ajax(
            {
                url: route_url,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){

                    var url ="{{ route('subscription_plan.index') }}"; //the url I want to redirect to
                        $(location).attr('href', url);
                    //alert("Record Deleted Succesfully");
                }
            });
           
        });

  </script>

<!-- Delete subscripion script end -->

<!-- Edit subscripion script start -->

  <script type="text/javascript">

        $(".subscrptionEdit").click(function(){
            var price=$(this).data("price");
            var month=$(this).data("month");
            var description=$(this).data("description");
            var id=$(this).data("id");

            $("#price").val(price);
            $("#month").val(month);
            $("#description").val(description);
            $("#update_id").val(id);
           
           $("#exampleModal").modal('show');        
        });



      jQuery('#editSubscriptionPlan').click(function(e){

            var price= $("#price").val();
            var month= $("#month").val();
            var description= $("#description").val();
            var id= $("#update_id").val();

            var update_url = '{{ route("subscription_plan.update", ":id") }}';
                update_route_url = update_url.replace(':id', id);
                //alert(update_route_url);

           
            //alert("hello")
           e.preventDefault();
           $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
          });
           jQuery.ajax({
              url: update_route_url,
              method: 'PUT',
              data: {
                 id: id,
                 price: price,
                 month: month,
                 description: description,
                 "_token": "{{ csrf_token() }}"

                 //score: jQuery('#score').val(),
              },
              success: function(result){
                //alert(JSON.stringify(result,null,4))
                if(result.errors)
                {
                    jQuery('.alert-danger').html('');

                    jQuery.each(result.errors, function(key, value){
                        jQuery('.alert-danger').show();
                        jQuery('.alert-danger').append('<li>'+value+'</li>');
                    });
                }
                else
                {
                    jQuery('.alert-danger').hide();
                    $('#open').hide();
                    $('#exampleModal').modal('hide');

                     var url ="{{ route('subscription_plan.index') }}"; //the url I want to redirect to
                        $(location).attr('href', url);
                        //location.reload();
                }
              }});
           });


  </script>
@endpush