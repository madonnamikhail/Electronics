@extends('layouts.dashboard')
@section('title', 'Edit Spec')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Spec') }}</h3>
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
      <form method="post" action="{{ route('update.specc',$specc->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Name') }}</label>
            <input type="text" name="name" value="{{ $specc->name  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter city english name">
          </div>
          @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
