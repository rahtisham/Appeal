<!-- Extends template page -->
@extends('app')

@section('title', 'Profile')

<!-- Specify content -->
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-1">
                </div>
                <!-- /.col -->
                <!--end of col-sm-1-->
                <div class="col-md-10 card p-4">

                    <div class="tab-pane " id="walmartsettings">
                        <form class="form-horizontal" method="post" action="{{ url('check') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="walmart_service_name" class="col-sm-4 col-form-label">Walmart Service Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="walmart_service_name" name="clientName" placeholder="Walmart Service Name" value="{{ @$walmart_settings[0]->walmart_service_name }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="client_id" class="col-sm-4 col-form-label">Client Id</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="client_id" name="clientID" placeholder="Client Id" value="{{ @$walmart_settings[0]->client_id }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="client_secret" class="col-sm-4 col-form-label">Client Secret</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="client_secret" name="clientSecretID" placeholder="Client Secret" value="{{ @$walmart_settings[0]->client_secret }}" required>
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
