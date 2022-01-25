<!-- Extends template page-->
@extends('app')

@section('title', 'Walmart Item List')

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
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Mart</th>
                <th>Wpid</th>
                <th>SKU </th>
                <th>UPC</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Status</th>
              </tr>
              </thead>
              <tbody>
                @foreach($items as $item)
                  <tr>
                    <td>{{$item->mart}}</td>
                    <td>{{$item->wpid}}</td>
                    <td>{{$item->sku}}</td>
                    <td>{{$item->upc}}</td>
                    <td>{{$item->productName}}</td>
                    <td>{{$item->productType}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->publishedStatus}}</td>
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
@stop