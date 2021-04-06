@extends('layouts.dashboard')
@section('title','Add Static Page')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New Static Page') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('create.staticPage')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Title') }}</label>
            <input type="text" name="title_en"  value="{{ old('title_en') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter  english title">
          </div>
          @error('title_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Arabic Title') }}</label>
                <input type="text" name="title_ar"  value="{{ old('title_ar') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter  arabic title">
              </div>
              @error('title_ar')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Details') }}</label>
            <input type="text" name="details_en"  value="{{ old('details_en') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter  english details">
            </div>
            @error('details_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.Arabic Details') }}</label>
                    <input type="text" name="details_ar"  value="{{ old('details_ar') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter  english details">
                    </div>
                    @error('details_ar')
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
