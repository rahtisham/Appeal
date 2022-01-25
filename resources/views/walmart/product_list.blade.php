<!-- Extends template page-->
@extends('app')

@section('title', 'Scrapped Product List')

<!-- Specify content -->
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
            <a class='btn btn-sm btn-info float-right' href="{{route('walmartScrap')}}">Scrap Products</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Image</th>
                <th>ProductId </th>
                <th>name</th>
                <th>WalmartPrice</th>
                <th>AmazonPrice</th>
                <th>Profitable</th>
              </tr>
              </thead>
              <tbody>
                @foreach($walmartProducts as $product)
                  <?php //echo "<pre>";print_r($product['productid']);exit; ?>
                    <tr>
                        <?php if(Storage::has('public/walmartImg/'.$product['images'])){
                          $images = URL::asset('storage/walmartImg/'.$product['images']);
                        } else { $images = ''; } ?>
                        <td>
                            <img src="<?php echo $images; ?>" alt="Product" width="100">
                        </td>
                      <td>{{ $product['productid'] }}</td>
                      <td>{{ $product['name'] }}</td>
                      <td>{{ $product['price'] }}</td>
                      <td>{{ $product['amazonPrice'] }}</td>
                      <td><?php if($product['price'] > $product['amazonPrice']){ echo 'Walmart';} elseif($product['price'] < $product['amazonPrice']) { echo 'Amazon'; } else { echo 'NA'; } ?></td>
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