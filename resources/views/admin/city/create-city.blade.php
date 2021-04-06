@extends('layouts.dashboard')
@section('title', 'Add City')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New City') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('store.city') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Name') }}</label>
            <input type="text" name="name_en"  value="{{ old('name_en') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter city english name">
          </div>
          @error('name_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Arabic Name') }}</label>
                <input type="text" name="name_ar"  value="{{ old('name_ar') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter city arabic name">
              </div>
              @error('name_ar')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Latitude') }}</label>
            <input type="text" name="lat" value="{{ old('lat') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter lat">
          </div>
          @error('lat')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          <div class="form-group">
            <label for="exampleInputFile">{{ __('message.Logitude') }}</label>
            <input type="text" name="longg" value="{{ old('longg') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter longg">

            @error('longg')
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
