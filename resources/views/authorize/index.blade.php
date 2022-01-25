<!-- Extends template page-->
@extends('app')

@section('title', 'Add New Product')

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
                   <a href="{{ route('pay') }}" class="btn btn-sm btn-primary float-right">Add Payment</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name on Card</th>
                        <th>Response Code</th>
                        <th>Transaction Id</th>
                        <th>Message Code</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $index=1;
                        @endphp
                        @foreach($payment_logs as $payment)
                            
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $payment->name_on_card }}</td>
                                <td>{{ $payment->response_code }}</td>
                                <td>{{ $payment->transaction_id }}</td>
                                <td>{{ $payment->message_code }}</td>
                                <td>{{ $payment->quantity }}</td>
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

@stop