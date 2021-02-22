@extends('layouts.dashboard')
@section('title','New supplier')

@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New Supplier') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('store.supplier') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Name') }}</label>
            <input type="text" name="name_en"  value="{{ old('name_en') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Product english name">
          </div>
          @error('name_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Arabic Name') }}</label>
                <input type="text" name="name_ar"  value="{{ old('name_ar') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Product arabic name">
              </div>
              @error('name_ar')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Email') }} </label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
          </div>
          @error('email')
                <span class="text-danger">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.National ID') }}</label>
                <input type="text" name="nationalID" value="{{ old('nationalID') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter nationalID ">
              </div>
              @error('nationalID')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror

                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.Phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter your phone">
                  </div>
                  @error('"phone')
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



                      {{-- <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Product') }}</label>
                        <select name="product_id" class="form-control">
                            @foreach ($products as $products )
                            <option {{ old('product_id')==$products->id ? 'selected' : '' }} value="{{ $products->id }}">{{ $products->name_en }}</option>
                            @endforeach
                          </select>                      </div>
                      @error('product_id')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror --}}


       
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
