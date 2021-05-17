@extends('layouts.dashboard')
@section('title','Edit Permission')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header bg-warning">
        <h3 class="card-title">{{ __('message.Edit Permission') }}</h3>
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
      <form method="post" action="{{ route('update.permissions.role',$permission->id) }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Permission Name') }}</label>
            <input type="text" name="name" value="{{$permission->name}}" class="form-control" id="exampleInputEmail1" placeholder="Edit Permission Name">
          </div>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">Gaurd</label>
            <select name="guard_name" class="form-control">
                @foreach ($guards as $guard )
                <option {{ $permission->guard_name==$guard ? 'selected' : '' }} value="{{ $guard }}">{{ $guard }}</option>
                @endforeach
            </select>
          </div>
            @error('guard_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            {{-- <div class="form-group">
                <label for="exampleInputEmail1">Permissions</label>
                <br>
                  @foreach ($all_permissions as $all_permission)
                    <input type='checkbox'  {{ $role->hasPermissionTo($all_permission->name) ? 'checked' : '' }} name='permission_id[]' value='{{ $all_permission->id }}'>{{ $all_permission->name }}<br>
                  @endforeach
                </div>
            @error('permission_id[]')
                    <span class="text-danger">{{ $message }}</span>
                @enderror --}}
          <button type="submit" class="btn btn-warning">{{ __('message.Edit') }}</button>
        </div>
      </form>
    </div>

@endsection
