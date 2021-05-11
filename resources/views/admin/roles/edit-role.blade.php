@extends('layouts.dashboard')
@section('title','Edit Role')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Role') }}</h3>
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
      <form method="post" action="{{ route('update.role.permissions',$role->id) }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Role Name') }}</label>
            <input type="text" name="name" value="{{$role->name}}" class="form-control" id="exampleInputEmail1" placeholder="Edit Role Name">
          </div>
          @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">Gaurd</label>
                <select name="guard_name" class="form-control">
                    @foreach ($guards as $guard )
                    <option {{ $role->guard_name==$guard ? 'selected' : '' }} value="{{ $guard }}">{{ $guard }}</option>
                    @endforeach
                </select>
                </div>
            @error('guard_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                {{-- <div class="form-group">
                    <label for="exampleInputEmail1">Permissions</label>
                    <br>
                        @foreach ($permissions as $permission )
                        <input type='checkbox' {{ $permission->permission_id==$permission ? 'checked' : '' }} name='permission_id[]' value='{{ $permission->id }}'>{{ $permission->name }}<br>
                        @endforeach
                    </div>
                @error('permission_id[]')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror --}}
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
