<!-- Extends template page-->
@extends('app')

@section('title', 'Add New Product')

<!-- Specify content -->
@section('content')

<section class="content">
  <div class="container">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Add Product</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" id="quickForm" method="post" action="{{ route('product.upload') }}">
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="sku">SKU</label>
                  <input type="text" name="sku" class="form-control" id="sku" placeholder="Enter Product SKU">
                </div>
                <div class="form-group col-md-4">
                  <label for="upc">UPC</label>
                  <input type="text" name="upc" class="form-control" id="upc" placeholder="Enter Product UPC">
                </div>
                <div class="form-group col-md-4">
                  <label for="sku">Product TaxCode</label>
                  <input type="text" name="productTaxCode" class="form-control" id="productTaxCode" placeholder="Enter Product TaxCode">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="title">Title</label>
                  <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
                  <label for="brand">Brand</label>
                  <input type="text" name="brand" class="form-control" id="brand" placeholder="Enter Product Brand">
                </div>
                <div class="form-group col-md-6">
                  <label for="sku">Short Description</label>
                  <textarea type="text" name="shortdesc" rows="4" class="form-control" id="shortdesc"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="cost">Cost</label>
                  <input type="text" name="cost" class="form-control" id="cost" placeholder="Enter Product Cost">
                </div>
                <div class="form-group col-md-6">
                  <label for="manufacturer">Manufacturer</label>
                  <input type="text" name="manufacturer" class="form-control" id="manufacturer" placeholder="Enter Manufacturer Name">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="itemType">ItemType</label>
                  <input type="text" name="itemType" class="form-control" id="itemType" placeholder="Enter ItemType">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
        </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop