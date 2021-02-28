@extends('layouts.dashboard')
@section('title','Add Order')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New Order') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('store.order') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Order Status') }}</label>
            <input type="text" name="status"  value="{{ old('status') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter status">
          </div>
          @error('name_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Arabic Name') }}</label>
            <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter category Arabic name">
          </div>
          @error('name_ar')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          <div class="form-group">
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
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>

@endsection
