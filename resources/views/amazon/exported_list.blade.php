<!-- Extends template page-->
@extends('app')

@section('title', 'Amazon Product List')

<!-- Specify content -->
@section('content')

<section class="content">
  <div class="container">
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
            <table id="tblamazonpro" class="table">
              <thead>
              <tr>
                <!-- <th>Image</th> -->
                <th>ASIN </th>
                <th>name</th>
                <th>Brand</th>
                <th>color</th>
                <th>productType</th>
                <th>Price</th>
                <th>currencyCode</th>
                <th>packageHeight</th>
                <th>packageLength</th>
                <th>packageWidth</th>
                <th>packageWeight</th>
                <th>size</th>
                <th>Total Fees</th>
                <th>referralFee</th>
                <th>closingFee</th>
                <th>perItemFee</th>
                <th>fbaFees</th>
                <th>estimatedSales</th>
                <th>shippingCost</th>
                <th>fixedAdditionalCost</th>
                <th>percentAdditionalCost</th>
                <th>profit</th>
                <th>ROI</th>
                <!-- <th>View</th> -->
              </tr>
              </thead>
              <tbody>
                @foreach($amazonProducts as $product)
                  <?php //echo "<pre>";print_r($product['productid']);exit; ?>
                    <tr>
                        <!-- <?php if(Storage::has('public/walmartImg/'.$product['images'])){
                          $images = URL::asset('storage/walmartImg/'.$product['images']);
                        } else { $images = ''; } ?>
                        <td>
                            <img src="<?php echo $images; ?>" alt="Image" width="100">
                        </td> -->
                      <td>{{ $product['asin'] }}</td>
                      <td>{{ $product['title'] }}</td>
                      <td>{{ $product['brand'] }}</td>
                      <td>{{ !empty($product['color'])?$product['color']:'-' }}</td>
                      <td>{{ $product['productType'] }}</td>
                      <td>{{ $product['price'] }}</td>
                      <td>{{ $product['currencyCode'] }}</td>
                      <td>{{ !empty($product['packageHeight'])?$product['packageHeight']:'NA' }}</td>
                      <td>{{ !empty($product['packageLength'])?$product['packageLength']:'NA' }}</td>
                      <td>{{ !empty($product['packageWidth'])?$product['packageWidth']:'NA' }}</td>
                      <td>{{ !empty($product['packageWeight'])?$product['packageWeight']:'NA' }}</td>
                      <td>{{ $product['size'] }}</td>
                      <td>{{ $product['totalFees'] }}</td>
                      <td>{{ $product['referralFee'] }}</td>
                      <td>{{ $product['closingFee'] }}</td>
                      <td>{{ $product['perItemFee'] }}</td>
                      <td>{{ $product['fbaFees'] }}</td>
                      <td>{{ !empty($product['estimatedsales'])?$product['estimatedsales']:'-' }}</td>
                      <td>{{ !empty($product['shippingcost'])?$product['shippingcost']:'-' }}</td>
                      <td>{{ !empty($product['fixedadditionalcost'])?$product['fixedadditionalcost']:'-' }}</td>
                      <td>{{ !empty($product['percentadditionalcost'])?$product['percentadditionalcost']:'-' }}</td>
                      <td>{{ !empty($product['profit'])?$product['profit']:'-' }}</td>
                      <td>{{ !empty($product['roi'])?$product['roi']:'-' }}</td>
                      <!-- <td><button type="button" class="btn btn-info btn-sm" onclick="viewdetail({{ json_encode($product) }});">View</button>
                          <button type="button" class="btn btn-info btn-sm">Compaire</button>
                      </td> --> 
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
