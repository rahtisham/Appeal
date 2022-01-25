@extends('app')

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
            <button class='btn btn-sm btn-primary float-right' onclick="openbatch();">Add Batch</button>
          </div>
          <div class="card-body">

            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                   <th>Batch Name</th>
                   <th>Ship From</th>
                   <th>Packing Type</th>
                   <th>Channel</th>
                   <th width="280px">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($batches as $key => $batch)
                <tr class="pointer" href="{{ URL::to('/list?id=') }}{{$batch->id}}">
                    <td>{{ $batch->name }}</td>
                    <td>{{ $batch->ship_from }}</td>
                    <td>{{ $batch->packing_type }}</td>
                    <td>{{ $batch->channel }}</td>
                    <td><a class="btn btn-sm btn-primary" href="javascript::void();" onclick="editbatch({{$batch->id}});">Edit</a>
                        <a href="" class="btn btn-sm btn-danger">Delete</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
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
</section>

@endsection