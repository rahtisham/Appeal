<!-- Extends template page -->
@extends('app')

@section('title', 'Profile')

<!-- Specify content -->
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-9 card p-4">

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


{{--                            <div class="form-group row">--}}
{{--                                <label for="correlation_id" class="col-sm-4 col-form-label">Correlation ID</label>--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <input type="text" class="form-control" id="correlation_id" name="correlation_id" placeholder="Correlation ID" value="{{ @$walmart_settings[0]->correlation_id }}" required>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
                <!-- /.col -->
                <div class="col-md-3">
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

@stop
