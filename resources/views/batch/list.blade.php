@extends('app_batch')

@section('title', 'Batch')

@section('content')

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
            @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class') }}">
               {{ Session::get('message') }}
            </div>
            @endif
            <div class="card-header">
                <form id="frm_asin_srch"> 
                    <div class="form-inline">
                        <div class="input-group" data-widget="sidebar-search">
                            <input class="form-control form-control-sidebar" type="Search" placeholder="Asin" id="asin_txt" aria-label="Search Asin">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sidebar" id="search_asin">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
              <table class="table table-striped projects" id="itemtbl">
                  
              </table>
            </div>
            <div class="shipping_item" style="display:none">
                <form role="form" id="quickForm" novalidate="novalidate">
                    <div class="card-body">
                        
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Total Quantity</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" name="total_qty" class="form-control" placeholder="Total Quantity">
                             
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Avg Cost/Unit</label>
                            </div>
                            <div class="col-sm-2">
                              
                                <input type="number" name="avg_cost" class="form-control" placeholder="Total Quantity">
                              
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Date</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask="" im-insert="false">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Supplier</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="supplier" class="form-control" placeholder="Supplier">
                             
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Expiration</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask-alias="datetime" name="expiration" data-inputmask-inputformat="mm/dd/yyyy" data-mask="" im-insert="false">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>MSKU</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="supplier" class="form-control" placeholder="Supplier" disabled="">
                             
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Condition</label>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control" name="Condition">
                                    <option>New</option>
                                    <option>Like New</option>
                                    <option>Good</option>
                                </select>
                             
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Condition Notes</label>
                            </div>
                            <div class="col-sm-6">
                                <textarea name="supplier" class="form-control" placeholder="Supplier"></textarea>
                             
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="alert alert-danger" style="display:none"></div>
        <div class="modal-header">
          
            <h5 class="modal-title">Batch Detail:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {!! Form::open(array('route' => 'batch.store','method'=>'POST')) !!}
        <div class="modal-body">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Batch Name</label>
                        {!! Form::text('batch_name', null, array('placeholder' => 'Batch Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ship From</label>
                        {!! Form::text('ship_from', null, array('placeholder' => 'Ship From','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Packing Type</label>
                        {!! Form::text('packing_type', null, array('placeholder' => 'Packing Type','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Channel</label>
                        <select name="channel" class="form-control">
                            <option>FBA</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Workflow Type</label>
                        <select name="workflow" class="form-control">
                            <option>Private</option>
                            <option>Live</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Labeling Preference</label>
                        <select name="labeling" class="form-control">
                            <option>I will Lable all my items</option>
                            <option>FBA should lable my items</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Provide Box Content</label>
                        <select name="box_content" class="form-control">
                            <option>ON</option>
                            <option>OFF</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Min/Max Preference</label>
                        <select name="min_max" class="form-control">
                            <option>Do not Capture</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Shipping Method</label>
                        <select name="ship_method" class="form-control">
                            <option>SPD</option>
                            <option>LTD</option>
                        </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit"  class="btn btn-success" id="ajaxSubmit">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  <div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="mskuModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="alert alert-danger" style="display:none"></div>
        <div class="modal-header">
            <h5 class="modal-title">Generate MSKU</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {!! Form::open(array('route' => 'createmsku','method'=>'POST','id' => 'mskuform')) !!}
        <div class="modal-body">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">MSKU</label>
                    <input type="text" name="msku" id="msku" class="form-control">
                </div>
                <input type="hidden" name="itemasin" id="itemasin" value="">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="mskusubmit">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</section>

@endsection