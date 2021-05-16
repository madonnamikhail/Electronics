@extends('layouts.dashboard')
@section('title','Edit Admin')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Admin') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      @if(Session()->has('Success'))
        <div class="alert alert-success">{{ Session()->get('Success') }}</div>
        @php
          Session()->forget('Success');
        @endphp
      @endif
      @if(Session()->has('Error'))
            <div class="alert alert-danger">{{ Session()->get('Error') }}</div>
            @php
            Session()->forget('Error');
            @endphp
    @endif
      <form method="post" action="{{ route('update.admin',$admin->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Admin Name') }}</label>
            <input type="text" name="name" value="{{$admin->name  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter admin name">
          </div>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">Gaurd</label>
            <select name="guard_name" class="form-control">
                @foreach ($guards as $guard )
                <option {{ $rroles->guard_name == $guard ? 'selected' : '' }} value="{{ $guard }}">{{ $guard }}</option>
                @endforeach
            </select>
            </div>
            @error('guard_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror

          <div class="form-group d-flex">
            <label for="exampleInputEmail1">Roles
            <br>
            @foreach ($roles as $role)
              <input {{ ($admin->hasRole($role)) ? 'checked':''}} id="perm_id_{{$role->id}}" type='checkbox' name='role_id[]' value='{{ $role->id }}'>
              <label for="perm_id_{{$role->id}}" style="font-weight: 400">{{ $role->name }}</label>
            @endforeach
            </label>
          </div>
          @error('role_id[]')
              <span class="text-danger">{{ $message }}</span>
          @enderror

          
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
