@extends('layouts.dashboard')
@section('title','Edit Static Page')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Static Page') }}</h3>
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
      <form method="post" action="{{ route('update.staticPage',$staticPage->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Tiltle') }}</label>
            <input type="text" name="title_en" value="{{$staticPage->title_en  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter category english name">
          </div>
          @error('title_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Arabic Tiltle') }}</label>
                <input type="text" name="title_ar" value="{{$staticPage->title_ar  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter category english name">
              </div>
              @error('title_ar')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
              <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Details') }}</label>
            <input type="text" name="details_en" value="{{$staticPage->details_en }}" class="form-control" id="exampleInputEmail1" placeholder="Enter category Arabic name">
          </div>
          @error('details_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Arabic Details') }}</label>
                <input type="text" name="details_ar" value="{{$staticPage->details_ar }}" class="form-control" id="exampleInputEmail1" placeholder="Enter category Arabic name">
              </div>
              @error('details_ar')
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
