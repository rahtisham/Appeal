<!-- Extends template page-->
@extends('app')

@section('title', 'Walmart Product List')

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
            <form role="form" id="filterprofit" method="post" action="{{ route('walmartproductlist') }}">
            @csrf
              <div class="row">
                <div class="form-group col-md-4">
                  <button type="button" id="upload_on_amazon" class="btn btn-warning">Bulk Upload On Amazon</button>
                </div>
                <div class="form-group col-md-3">
                  <select class="form-control" name="filteroption">
                    <option value="all">All</option>
                    <option value="profitable_on_amazon" <?php if($filteroption == "profitable_on_amazon"){ echo "selected"; } ?>>Profitable on Amazon</option>
                    <option value="profitable_on_walmart" <?php if($filteroption == "profitable_on_walmart"){ echo "selected"; } ?>>Profitable on Walmart</option>
                    <option value="non_profitable" <?php if($filteroption == "non_profitable"){ echo "selected"; } ?>>Non Profitable</option>
                    <option value="profit_lessthan_50" <?php if($filteroption == "profit_lessthan_50"){ echo "selected"; } ?>>Profit < $50</option>
                    <option value="profit_50to100" <?php if($filteroption == "profit_50to100"){ echo "selected"; } ?>>Profit $50 - $100</option>
                    <option value="profit_greaterthan_100" <?php if($filteroption == "profit_greaterthan_100"){ echo "selected"; } ?>>Profit > $100</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <!----------------------- Filter ---------------------------->

                <div class="form-group col-md-2 d-flex justify-content-end">
                  <!--filter-->
                  <div id="mySidenav" class="sidenav">
                     <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                     <div>
                        <button type="button" class="walmartProductfilter btn_filter">Apply</button>
                     </div>
                     <!--panel collapse-->
                    <div class="scan_detail">
                      <span href="#">Scan Filters</span>
                      <p>Apply filters to finds products that meet your criteria</p>
                      <button class="des-accordion head_upc" type="button">
                        <span class="title">UPC</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                            <div class="d-flex-inlinebtn">
                            </div>
                            <select class="form-select" aria-label="Default select example" data-title="upc" name="filtercondition">
                                <option selected value="∈">Contains</option>
                                <option value="!~">Does Not Contain</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                            </select>
                            <input type="text" name="filtervalue" placeholder="Value">
                            <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">ProductId</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="productid" name="filtercondition">
                                <option selected value="∈">Contains</option>
                                <option value="!~">Does Not Contain</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">WalmartId</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="walmartid" name="filtercondition">
                                <option selected value="∈">Contains</option>
                                <option value="!~">Does Not Contain</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Name</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="name" name="filtercondition">
                                <option selected value="∈">Contains</option>
                                <option value="!~">Does Not Contain</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Walmart Price</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="price" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Amazon Price</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="amazonPrice" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Profit</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="profit" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Roi</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="roi" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Model</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="model" name="filtercondition">
                                <option selected value="∈">Contains</option>
                                <option value="!~">Does Not Contain</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Brand</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="brand" name="filtercondition">
                                <option selected value="∈">Contains</option>
                                <option value="!~">Does Not Contain</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">ProductType</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="productType" name="filtercondition">
                                <option selected value="∈">Contains</option>
                                <option value="!~">Does Not Contain</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">TotalFees</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="totalFees" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">ReferralFee</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="referralFee" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">ClosingFee</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="closingFee" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">PerItemFee</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="perItemFee" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">FbaFees</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="fbaFees" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Estimatedsales</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="estimatedsales" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <button class="des-accordion head_upc" type="button">
                        <span class="title">Shippingcost</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="shippingcost" name="filtercondition">
                                <option selected value="<">Less Than</option>
                                <option value="<=">Less Than or Equal</option>
                                <option value=">">Greater Than</option>
                                <option value=">=">Greater Than Or Equal</option>
                                <option value="=">Equal</option>
                                <option value="!=">Not Equal</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div>

                      <!-- <button class="des-accordion head_upc" type="button">
                        <span class="title">Status</span>
                        <span class="accicon"><i class="fas fa-angle-down rotate-icon"></i></span>
                      </button>
                      <div class="panel">
                        <div class="card-body">
                             <div class="d-flex-inlinebtn">
                             </div>
                             <select class="form-select" aria-label="Default select example" data-title="processingStatus" name="filtercondition">
                                <option selected value="_SUBMITTED_">SUBMITTED</option>
                                <option value="_CANCELED_">CANCELED</option>
                                <option value="_IN_PROGRESS_">IN PROGRESS</option>
                                <option value="_DONE_">DONE</option>
                             </select>
                             <input type="text" name="filtervalue" placeholder="Value">
                             <button type="button" class="add_filter">Add</button>
                        </div>
                      </div> -->

                    </div>
                  </div>
                  <span onclick="openNav()"><i class="fa fa-filter"></i>filter</span>
                </div>
                <!-- ------------------------------ -->

              </div>
            </form>
            <table id="tblwalmart" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th><div class="custom-control custom-checkbox"><input type="checkbox" name="chkall" id="chkall" class="custom-control-input custom-control-input-danger" style="z-index: 0;opacity: 1;" /></div></th>
                <th>Image</th>
                <th>WalmartPrice</th>
                <th>AmazonPrice</th>
                <th>Profitable</th>
                <th>ReferralFee</th>
                <th>closingFee</th>
                <th>perItemFee</th>
                <th>fbaFees</th>
                <th>profit</th>
                <th>ROI</th>
                <th>name</th>
                <th>ProductId </th>
                <th>Model</th>
                <th>Brand</th>
                <th>ProductType</th>
                <th>Upc</th>
                <th>Delivery days</th>
                <th>View</th>
              </tr>
              </thead>
              <tbody>
                @foreach($walmartProducts as $product)
                  <?php //echo "<pre>";print_r($product['productid']);exit; ?>
                    <tr>
                      <td>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input custom-control-input-danger" name="chkbx[]" id="chkbx" value="{{ $product['id'] }}" style="z-index: 0;opacity: 1;" /></div></td>
                        <?php if(Storage::has('public/walmartImg/'.$product['images'])){
                          $images = URL::asset('storage/walmartImg/'.$product['images']);
                        } else { $images = ''; } ?>
                        <td>
                            <img src="<?php echo $images; ?>" alt="Image" width="100">
                        </td>
                      <td>${{ $product['price'] }}</td>
                      <td>${{ $product['amazonPrice'] }}</td>
                      <td><?php if($product['price'] > $product['amazonPrice']){ echo 'Walmart';} elseif($product['price'] < $product['amazonPrice']) { echo 'Amazon'; } else { echo 'NA'; } ?></td>
                      <td>${{ !empty($product['referralFee'])?$product['referralFee']:'0.00' }}</td>
                      <td>${{ !empty($product['closingFee'])?$product['closingFee']:'0.00' }}</td>
                      <td>${{ !empty($product['perItemFee'])?$product['perItemFee']:'0.00' }}</td>
                      <td>${{ !empty($product['fbaFees'])?$product['fbaFees']:'0.00' }}</td>
                      <td>
                        <?php if($product['profit'] > 0){ ?>
                          <span class="badge bg-success">
                            ${{ !empty($product['profit'])?$product['profit']:'0.00' }}
                          </span>
                        <?php } elseif($product['profit'] <= 0){ ?>
                          <span class="badge bg-danger">
                            ${{ !empty($product['profit'])?$product['profit']:'0.00' }}
                          </span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if($product['roi'] > 0){ ?>
                          <span class="badge bg-success">
                            {{ !empty($product['roi'])?$product['roi']:'0.00' }}%
                          </span>
                        <?php } elseif($product['roi'] <= 0){ ?>
                          <span class="badge bg-danger">
                            {{ !empty($product['roi'])?$product['roi']:'0.00' }}%
                          </span>
                        <?php } ?>
                      </td>
                      <td>{{ $product['name'] }}</td>
                      <td>{{ $product['productid'] }}</td>
                      <td>{{ $product['model'] }}</td>
                      <td>{{ $product['brand'] }}</td>
                      <td>{{ $product['productType'] }}</td>
                      <td>{{ $product['upc'] }}</td>
                      <td>{{ $product['delivery_days'] }}</td>
                      <td>
                        <button type="button" class="btn btn-info btn-sm" onclick="viewdetail({{ json_encode($product) }});">View</button>
                        <!-- <a href="{{ route('product.upload',[$product['id']]) }}">
                          <button type="button" class="btn btn-info btn-sm">
                            <?php if($product['price'] > $product['amazonPrice']){ echo 'Upload on Walmart';} elseif($product['price'] < $product['amazonPrice']) { echo 'Upload on Amazon'; } else { echo 'NA'; } ?>
                          </button>
                        </a> -->
                      </td>
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
        <form method="post" action="{{ route('product.upload') }}">
            @csrf
        <!-- Modal body -->
          <div class="modal-body">
            <div class="container">
              <table class="table" id="detail">
                
              </table>
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
              <input type="hidden" id="productid" name="productid">
              <button type="submit" class="btn btn-primary">Upload On Amazon</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
        
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
    $('#detail').html('');
    var productData = '<tbody><tr><th>walmartid</th><td>'+data.walmartid+'</td></tr><tr><th>Upc</th><td>'+data.upc+'</td></tr><tr><th>Title</th><td>'+data.name+'</td></tr><tr><th>Brand</th><td>'+data.brand+'</td></tr><tr><th>Model</th><td>'+data.model+'</td></tr><tr><th>Description</th><td>'+data.description+'</td></tr><tr><th>Price</th><td><input type="text" name="newprice" value="'+data.price+'"></td></tr></tbody><input type="hidden" name="postdata[]" value="'+data+'" />';
    $( "#detail" ).append( productData );
    $( "#productid" ).val(data.id);
    $('#productModal').modal('toggle');
  }
</script>
@stop