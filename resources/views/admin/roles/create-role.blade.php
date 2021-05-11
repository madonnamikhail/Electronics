@extends('layouts.dashboard')
@section('title','Create Role')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New Role') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('store.role') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Name') }}</label>
            <input type="text" name="name"  value="{{ old('name') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Role name">
          </div>
          @error('name')
                <span class="text-danger">{{ $message }}</span>
         @enderror
        <div class="form-group">
            <label for="exampleInputEmail1">Gaurd</label>
            <select name="guard_name" class="form-control">
                @foreach ($guards as $guard )
                <option {{ old('guard_name')==$guard ? 'selected' : '' }} value="{{ $guard }}">{{ $guard }}</option>
                @endforeach
            </select>
            </div>
        @error('guard_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="form-group">
                <label for="exampleInputEmail1">Permissions</label>
                <br>
                    @foreach ($permissions as $permission )
                    <input type='checkbox' name='permission_id[]' value='{{ $permission->id }}'>{{ $permission->name }}<br>
                    @endforeach
                </div>
            @error('permission_id[]')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
      </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>

@endsection
