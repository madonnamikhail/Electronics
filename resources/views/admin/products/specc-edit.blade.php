@extends('layouts.dashboard')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Product Spec') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('update.product.specs') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <h3 for="exampleInputEmail1">{{ __('message.Spec Name') }}: {{ $specs->name }}</h3>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Spec value') }}</label>
                <input type="hidden" name="spec_id" value="{{ $specs->id }}">

                @foreach ($specs->products as $spec)
                 <input type="text" name="value"  value="{{ $spec->pivot->value }}"class="form-control" id="exampleInputEmail1" placeholder="Spec Value">
                 <input type="hidden" name="product_id" value="{{ $spec->pivot->product_id }}">

                @endforeach
              </div>
              @error('value')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
