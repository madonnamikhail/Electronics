@extends('layouts.site')
@section('title', 'Edit Cart')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary" style="margin-top: 50px">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Cart') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('cart.product.update',$product->id) }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <img style="width:30%" src="{{ asset('images\product\\'. $product->photo ) }}" alt="">
            <h5>{{ $product->name_en }}</h5>
            </div>
          <div class="form-group">
            <label for="product_quantity">{{ __('message.Product Quantity') }}</label>
            <input type="number" name="product_quantity"  value="{{ $product_quantity }}" class="form-control" id="product_quantity" placeholder="Enter quantity">
          </div>
            @error('product_quantity')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
