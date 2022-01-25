<!-- Extends template page-->
@extends('app')

@section('title', 'User List')

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
            <a class='btn btn-sm btn-primary float-right' href="{{route('users.create')}}">Add New User</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action(s)</th>
              </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                  @if($user->id != '1')
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->role_id }}</td>
                      <td>{{ $user->status }}</td>
                      <td>
                         <!-- Edit -->
                         <a href="{{ route('users.edit',[$user->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                         <!-- Delete -->
                         <a href="{{ route('users.delete',$user->id) }}" class="btn btn-sm btn-danger">Delete</a>
                      </td>
                    </tr>
                  @endif
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