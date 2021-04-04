@extends('layouts.dashboard')
@section('title', 'Add Spec to Produuct')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Add Spec To Product') }}</h3>
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
      <form method="post" action="{{ route('store.specc.product') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="exampleInputEmail1">{{ __('message.Product') }}</label>
          <select name="product_id" id="subcategory"class="form-control">
              @foreach ($products as $product )
              <option {{ old('product_id')==$product->id ? 'selected' : '' }} value="{{ $product->id }}">{{ $product->name_en }}</option>
              @endforeach
            </select>
        </div>
        @error('product_id')
              <span class="text-danger">{{ $message }}</span>
            @enderror

        
            <div class="form-group">
              <label for="exampleInputEmail1">{{ __('message.Spec') }}</label>
              <select name="spec_id" id="subcategory"class="form-control">
                  @foreach ($speccs as $specc )
                  <option {{ old('specc_id')==$specc->id ? 'selected' : '' }} value="{{ $specc->id }}">{{ $specc->name }}</option>
                  @endforeach
                </select>
            </div>
            @error('spec_id')
                  <span class="text-danger">{{ $message }}</span>
                @enderror



        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Spec Value') }}</label>
            <input type="text" name="value" class="form-control" id="exampleInputEmail1" placeholder="Enter Spec Value">
          </div>
          @error('value')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
