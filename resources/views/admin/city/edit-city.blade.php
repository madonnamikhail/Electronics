@extends('layouts.dashboard')
@section('title', 'Edite City')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit City') }}</h3>
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
      <form method="post" action="{{ route('update.city',$city->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Name') }}</label>
            <input type="text" name="name_en" value="{{ $city->name_en  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter city english name">
          </div>
          @error('name_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Arabic Name') }}</label>
            <input type="text" name="name_ar" value="{{ $city->name_ar }}" class="form-control" id="exampleInputEmail1" placeholder="Enter city Arabic name">
          </div>
          @error('name_ar')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          
            <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Latitude') }}</label>
            <input type="text" name="lat" value="{{ $city->lat }}" class="form-control" id="exampleInputEmail1" placeholder="Enter city Latitude">
            </div>
            @error('lat')
                <span class="text-danger">{{ $message }}</span>
                @enderror

            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Logitude') }}</label>
                <input type="text" name="longg" value="{{ $city->longg }}" class="form-control" id="exampleInputEmail1" placeholder="Enter city Longitude">
            </div>
                @error('longg')
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
