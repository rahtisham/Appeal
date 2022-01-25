<!-- Extends template page-->
@extends('app')

@section('title', 'Amazon Order List')

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
            <form role="form" method="post" action="{{ route('orderList') }}">
            @csrf
              <div class="row">
                <div class="form-group col-md-2">
                  <label for="status">Order Status :</label>
                </div>
                <div class="form-group col-md-3">
                  <select class="form-control" name="orderstatus">
                    <option value="">All</option>
                    <option value="Shipped" <?php if($status == "Shipped"){ echo "selected"; } ?>>Shipped</option>
                    <option value="Canceled" <?php if($status == "Canceled"){ echo "selected"; } ?>>Canceled</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="form-group col-md-4">
                  <a href="{{ route('amazon.refreshOrders') }}"><button type="button" class="btn btn-warning float-right">Refresh Order</button></a>
                </div>
              </div>
            </form>
            <table id="orderTable" class="table">
              <thead>
              <tr>
                <th>AmazonOrderId </th>
                <th>OrderType </th>
                <th>PurchaseDate </th>
                <th>latestShipDate</th>
                <th>orderStatus</th>
                <th>amount</th>
                <th>currencyCode</th>
                <th>numberOfItemsShipped</th>
                <th>isReplacementOrder</th>
                <th>shipServiceLevel</th>
                <th>isBusinessOrder</th>
                <th>numberOfItemsUnshipped</th>
                <th>paymentMethod</th>
                <th>paymentMethodDetail</th>
                <th>isPremiumOrder</th>
                <th>city</th>
                <th>postalCode</th>
                <th>stateOrRegion</th>
                <th>countryCode</th>
                <th>isAddressSharingConfidential</th>
                <th>shipmentServiceLevelCategory</th>
                
              </tr>
              </thead>
              <tbody>
                @foreach($ordersList as $order)
                    <tr>
                      <td>{{ $order->amazonOrderId }}</td>
                      <td>{{ $order->orderType }}</td>
                      <td>{{ $order->purchaseDate }}</td>
                      <td>{{ $order->latestShipDate }}</td>
                      <td>
                        <?php if(trim($order->orderStatus) == "Shipped"){ ?>
                          <span class="badge bg-success">Shipped</span>
                        <?php } elseif(trim($order->orderStatus) == "Canceled"){ ?>
                          <span class="badge bg-danger">Canceled</span>
                        <?php } ?>
                      </td>
                      <td>{{ $order->amount }}</td>
                      <td>{{ $order->currencyCode }}</td>
                      <td>{{ $order->numberOfItemsShipped }}</td>
                      <td>{{ $order->isReplacementOrder }}</td>
                      <td>{{ $order->shipServiceLevel }}</td>
                      <td>{{ $order->isBusinessOrder }}</td>
                      <td>{{ $order->numberOfItemsUnshipped }}</td>
                      <td>{{ $order->paymentMethod }}</td>
                      <td>{{ $order->paymentMethodDetail }}</td>
                      <td>{{ $order->isPremiumOrder }}</td>
                      <td>{{ $order->city }}</td>
                      <td>{{ $order->postalCode }}</td>
                      <td>{{ $order->stateOrRegion }}</td>
                      <td>{{ $order->countryCode }}</td>
                      <td>{{ $order->isAddressSharingConfidential }}</td>
                      <td>{{ $order->shipmentServiceLevelCategory }}</td>
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
