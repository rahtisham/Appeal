<!-- Extends template page-->
@extends('app')

@section('title', 'Subscribers')

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
                        <th>Sr. No.</th>
                        <th>PRICE</th>
                        <th>NAME</th>
                        <th>MONTH</th>
                        <th>DESCRIPTION</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $index=1;
                        @endphp
                        @foreach($subscribers as $subscriber)
                        
                            <tr>
                                <td><strong>{{ $index }}</strong></td>
                                <td>{{ $subscriber->paid_amount }}</td>
                                <td>{{ $subscriber->name }}</td>
                                <td>{{ $subscriber->months }}</td>
                                <td>{{ $subscriber->description }}</td>
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
