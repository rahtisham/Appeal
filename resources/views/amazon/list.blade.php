<!-- Extends template page-->
@extends('app')

@section('title', 'Amazon Item List')

<!-- Specify content -->
@section('content')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        @if(Session::has('message'))
          <div class="alert {{ Session::get('alert-class') }}">
             {{ Session::get('message') }}
          </div>
        @endif
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <form role="form" method="post" action="{{ route('amazon.productList') }}">
            @csrf
              <div class="row">
                <div class="form-group col-md-1">
                  <label for="status">Status :</label>
                </div>
                <div class="form-group col-md-3">
                  <select class="form-control" name="mwsstatus">
                    <option value="">All</option>
                    <option value="_SUBMITTED_" <?php if($status == "_SUBMITTED_"){ echo "selected"; } ?>>SUBMITTED</option>
                    <option value="_IN_PROGRESS_" <?php if($status == "_IN_PROGRESS_"){ echo "selected"; } ?>>IN PROGRESS</option>
                    <option value="_CANCELED_" <?php if($status == "_CANCELED_"){ echo "selected"; } ?>>CANCELED</option>
                    <option value="_DONE_" <?php if($status == "_DONE_"){ echo "selected"; } ?>>DONE</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
            <table id="tblamazonstore" class="table">
              <thead>
              <tr>
                <th>UPC </th>
                <th>SKU </th>
                <th>Name</th>
                <th>Brand</th>
                <th>Color</th>
                <th>ProductType</th>
                <th>Price</th>
                <th>Status</th>
                <th>SubmissionId</th>
                <th>PackageHeight</th>
                <th>PackageLength</th>
                <th>PackageWidth</th>
                <th>PackageWeight</th>
                <th>Size</th>
              </tr>
              </thead>
              <tbody>
                @foreach($amazonProducts as $product)
                  <?php //echo "<pre>";print_r($product['productid']);exit; ?>
                    <tr>
                      <td>{{ $product->upc }}</td>
                      <td>{{ $product->sku }}</td>
                      <td>{{ $product->title }}</td>
                      <td>{{ $product->brand }}</td>
                      <td>{{ !empty($product->color)?$product->color:'-' }}</td>
                      <td>{{ $product->productType }}</td>
                      <td>{{ $product->price }}</td>
                      <td>
                        <?php if(trim($product->processingStatus) == "_SUBMITTED_"){ ?>
                          <span class="badge bg-primary">SUBMITTED</span>
                        <?php } elseif(trim($product->processingStatus) == "_CANCELED_"){ ?>
                          <span class="badge bg-danger">CANCELED</span>
                        <?php } elseif(trim($product->processingStatus) == "_IN_PROGRESS_"){ ?>
                          <span class="badge bg-warning">IN PROGRESS</span>
                        <?php } elseif(trim($product->processingStatus) == "_DONE_"){ ?>
                          <span class="badge bg-success">DONE</span>
                        <?php } ?>
                      </td>
                      <td>{{ $product->submissionId }}</td>
                      <td>{{ !empty($product->packageHeight)?$product->packageHeight:'NA' }}</td>
                      <td>{{ !empty($product->packageLength)?$product->packageLength:'NA' }}</td>
                      <td>{{ !empty($product->packageWidth)?$product->packageWidth:'NA' }}</td>
                      <td>{{ !empty($product->packageWeight)?$product->packageWeight:'NA' }}</td>
                      <td>{{ $product->size }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="productModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div id="detail">
            
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

</script>

<script type="text/javascript">

  function fetchData(transId='',o_id='',bbpsid='',number='',amount='',image='',status='',comment=''){
        
      $("#myModal").modal('show');
  
      $("#o_id").val(o_id);
      $("#bbpsid").val(bbpsid);
      $("#mobile_number").val(number);
      $("#amount").val(amount);
      if(status == 'Failure'){

          $("#status").val(status);
          $(".comment_section").show();
          $("#comment").prop('disabled', false);
          $("#comment").val(comment);
      } else {
          $("#comment").prop('disabled', true);
      }
      $("#edit_id").val(transId);
      if(image){
          var extension = image.substr( (image.lastIndexOf('.') +1) );

          if(extension == 'pdf'){
              $("#pdf_img").html('<iframe src="uploads/'+image+'" width="800px" height="800px"></iframe>');
          } else {
              $('#transImg').attr('src', 'uploads/'+image);
          }
      }
  }

  function viewdetail(data){
    //console.log(data.productid);
    //$('#detail').html(data);
    $( "#detail" ).append( data );
    $('#productModal').modal('toggle');
  }
</script>
@stop
