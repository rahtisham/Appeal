<!-- Extends template page -->
@extends('app')

@section('title', 'Edit User')

<!-- Specify content -->
@section('content')

<section class="content">
  <div class="container">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Edit User</h3>
          </div>
          <form role="form" id="quickForm" method="post" action="{{route('users.update',[$user->id])}}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name',$user->name)}}">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email"  class="form-control" id="exampleInputEmail1" required placeholder="Enter email" value="{{old('email',$user->email)}}">
              </div>
              
              <div class="form-group">
                <label for="role">Role</label>
                <select name="role_id" id="role" class="form-control">
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected="selected"' : '' }}>{{ $role->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                  <option value="Active" {{ $user->status == 'Active' ? 'selected="selected"' : '' }}>Active</option>
                  <option value="Deactive" {{ $user->status == 'Deactive' ? 'selected="selected"' : '' }}>Deactive</option>
                </select>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
        </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

@stop
