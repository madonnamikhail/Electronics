@extends('layouts.dashboard')
@section('title', 'Add user')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New User') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('create.user') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.User Name') }}</label>
            <input type="text" name="name"  value="{{ old('name') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter user name">
          </div>
          @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.User Email') }}</label>
                <input type="email" name="email"  value="{{ old('email') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter user email">
              </div>
              @error('email')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.User Password') }}</label>
                <input type="text" name="password"  value="{{ old('password') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter password">
              </div>
              @error('password')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                  <div class="form-group">
                    <label for="exampleInputFile">{{ __('message.User IMAGE') }}</label>
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
          <div class="form-group">
            <label for="exampleInputFile">{{ __('message.User Code') }}</label>
            <input type="text" name="code"  class="form-control" id="exampleInputEmail1" value="0" placeholder="Enter user code">

            @error('code')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          <div class="form-group">
            <label for="exampleInputFile">{{ __('message.User status') }}</label>
            <input type="text" name="status"  class="form-control" id="exampleInputEmail1" value="0"  placeholder="Enter user status">

            @error('status')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          <div class="form-group">
            <label for="exampleInputFile">{{ __('message.User phone') }}</label>
            <input type="number" name="phone" value="{{ old('phone') }}" class="form-control" id="exampleInputEmail1"  placeholder="Enter user phone">

            @error('phone')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
