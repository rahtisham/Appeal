<!-- Extends template page -->
@extends('app')

@section('title', 'Profile')

<!-- Specify content -->
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

           <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ asset('/images/profile.png') }}"
                     alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">{{ @$user[0]->name}}</h3>

              <p class="text-muted text-center">{{ @$user[0]->email }}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Status</b> <a class="float-right">{{ @$user[0]->status }}</a>
                </li>
                <li class="list-group-item">
                  <b>Role</b> <a class="float-right">{{ @$user[0]->role }}</a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  @if(Auth::user()->isAdmin())
                  <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                  @else
                  <li class="nav-item"><a class="nav-link " href="#profile" data-toggle="tab">Profile</a></li>
                  <li class="nav-item"><a class="nav-link active" href="#amazonsettings" data-toggle="tab">Amazon Settings</a></li>
                  <li class="nav-item"><a class="nav-link" href="#walmartsettings" data-toggle="tab">Walmart Settings</a></li>
                  @endif
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  @if(Auth::user()->isAdmin())
                  <div class="tab-pane active" id="profile">
                    <form class="form-horizontal" method="post" action="{{ route('mwsSettingUpdate') }}">
                      @csrf
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ @$user[0]->name }}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email v" value="{{ @$user[0]->email }}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Save Changes</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  @else
                  <div class="tab-pane" id="profile">
                    <form class="form-horizontal" method="post" action="{{ route('mwsSettingUpdate') }}">
                      @csrf
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ @$user[0]->name }}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email 1" value="{{ @$user[0]->email }}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Save Changes</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div class="active tab-pane" id="amazonsettings">
                    <form class="form-horizontal" method="post" action="{{ route('AmazonSettingsUpdate') }}">
                      @csrf
                      <div class="form-group row">
                        <label for="marketplaceid" class="col-sm-2 col-form-label">Market place id</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="marketplaceid" name="marketplaceid" placeholder="Market place id" value="{{ @$amazon_settings[0]->marketplace_id }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="client_id" class="col-sm-2 col-form-label">Client Id</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Client Id" value="{{ @$amazon_settings[0]->client_id }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="client_secret" class="col-sm-2 col-form-label">Client Secret</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="client_secret" name="client_secret" placeholder="Client Secret" value="{{ @$amazon_settings[0]->client_secret }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="access_key" class="col-sm-2 col-form-label">Access Key</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="access_key" name="access_key" placeholder="Access Key" value="{{ @$amazon_settings[0]->access_key }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="secret_key" class="col-sm-2 col-form-label">Secret key</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="secret_key" name="secret_key" placeholder="Secret key " value="{{ @$amazon_settings[0]->secret_key }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="refresh_token" class="col-sm-2 col-form-label">Refresh Token</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="refresh_token" name="refresh_token" placeholder="Refresh Token" value="{{ @$amazon_settings[0]->refresh_token }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="role_arn" class="col-sm-2 col-form-label">Role Arn</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="role_arn" name="role_arn" placeholder="Role Arn" value="{{ @$amazon_settings[0]->role_arn }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div class="tab-pane" id="walmartsettings">
                    <form class="form-horizontal" method="post" action="{{ route('walmartSetting') }}">
                      @csrf
                      <div class="form-group row">
                        <label for="client_id" class="col-sm-4 col-form-label">Client Id</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Client Id" value="{{ @$walmart_settings[0]->client_id }}" required>
                        </div>
                      </div>


                      <div class="form-group row">
                        <label for="client_secret" class="col-sm-4 col-form-label">Client Secret</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="client_secret" name="client_secret" placeholder="Client Secret" value="{{ @$walmart_settings[0]->client_secret }}" required>
                        </div>
                      </div>



                      <div class="form-group row">
                        <label for="walmart_service_name" class="col-sm-4 col-form-label">Walmart Service Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="walmart_service_name" name="walmart_service_name" placeholder="Walmart Service Name" value="{{ @$walmart_settings[0]->walmart_service_name }}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="correlation_id" class="col-sm-4 col-form-label">Correlation ID</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="correlation_id" name="correlation_id" placeholder="Correlation ID" value="{{ @$walmart_settings[0]->correlation_id }}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  @endif
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@stop
