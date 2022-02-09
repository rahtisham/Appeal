<!-- Extends template page -->
@extends('app')

@section('title', 'Profile')

<!-- Specify content -->
@section('content')

    <section class="content">
        <div class="container-fluid">
            <h1 style="text-align: center">Shipping Performance</h1><br><br>
            <div class="row">
                <!-- /.col -->
                <div class="col-md-1">
                </div>
                <!-- /.col -->
                <!--end of col-sm-1-->
                <div class="col-md-10 card p-4">

                    @if(\Session::has('success'))
                        <div class="alert alert-success">
                            <b>{{ \Session::get('success') }}</b>
                        </div>
                    @endif

                    <div class="tab-pane " id="walmartsettings">
                        <form class="form-horizontal" method="post" action="{{ url('dashboard/shipping_performance_integration') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="walmart_service_name" class="col-sm-4 col-form-label">Walmart Service Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="walmart_service_name" name="clientName" placeholder="Walmart Service Name" value="Muhammad Ahtisham" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="client_id" class="col-sm-4 col-form-label">Client Id</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="client_id" name="clientID" placeholder="Client Id" value="3db5b332-a208-4dec-bafe-153f7c026e78" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="client_secret" class="col-sm-4 col-form-label">Client Secret</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="client_secret" name="clientSecretID" placeholder="Client Secret" value="Up_Q9FXoQaFO3EjUePvpCKoSDbW5XlHjBmU1qeSwTEpH0inL37aSuRiZ7HvHOT9GEfaxM7-I_rzf7t54OVd-HA" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10" style="text-align: end !important;">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end of col-sm-10 -->

                </div>
                <!-- /.col -->
                <div class="col-md-1">
                </div>
                <!--end of col-sm-1-->
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

@stop
