@extends('app')

@section('title', 'Roles')

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
            <a class='btn btn-sm btn-primary float-right' href="{{route('roles.create')}}">Add New Role</a>
          </div>
          <div class="card-body">

            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                   <th>No</th>
                   <th>Name</th>
                   <th width="280px">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                        <a href="{{ route('roles.delete',$role->id) }}" class="btn btn-sm btn-danger">Delete</a>
                        <!-- @can('role-edit')
                            <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                        @endcan -->
                        <!-- @can('role-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan -->
                    </td>
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

{!! $roles->render() !!}
@endsection