@extends('layouts.dashboard')
@section('title','Add Admin')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New Admin') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('store.admin') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Name') }}</label>
            <input type="text" name="name"  value="{{ old('name') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter admin name">
          </div>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          
            <div class="form-group">
              <label for="exampleInputEmail1">{{ __('message.Password') }}</label>
              <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter Password">
            </div>
          @error('password')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Email') }}</label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Email">
          </div>
          @error('email')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">Gaurd</label>
            <select name="model_type" class="form-control">
                @foreach ($guards as $guard )
                <option {{ old('model_type')==$guard ? 'selected' : '' }} value="{{ $guard }}">{{ $guard }}</option>
                @endforeach
            </select>
          </div>
          @error('model_type')
              <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group d-flex">
            <label for="exampleInputEmail1">Roles
            <br>
                @foreach ($roles as $role)
                  <input id="perm_id_{{$role->id}}" type='checkbox' name='role_id[]' value='{{ $role->id }}'> 
                  <label for="perm_id_{{$role->id}}" style="font-weight: 400">{{ $role->name }}</label>
                @endforeach
              </label>
          </div>
          @error('role_id[]')
              <span class="text-danger">{{ $message }}</span>
          @enderror

          {{-- <div class="form-group">
            <label for="exampleInputFile">{{ __('message.IMAGE') }}</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>

              <div class="input-group-append">
                <span class="input-group-text">save</span>
              </div>
            </div>
            @error('photo')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          </div> --}}

          
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>

@endsection
