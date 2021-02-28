@extends('layouts.dashboard')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Product') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('update.product',$product->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Name') }}</label>
            <input type="text" name="name_en"  value="{{ $product->name_en }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Product  name">
          </div>
          @error('name_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Arabic Name') }}</label>
                <input type="text" name="name_ar"  value="{{ $product->name_ar }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Product  name">
              </div>
              @error('name_ar')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.price') }}</label>
            <input type="text" name="price" value="{{ $product->price }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Price">
          </div>
          @error('price')
                <span class="text-danger">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.code') }}</label>
                <input type="text" name="code" value="{{ $product->code }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product code">
              </div>
              @error('code')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror

                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.English details') }}</label>
                    <input type="text" name="details_en" value="{{ $product->details_en }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product details">
                  </div>
                  @error('details_en')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror

                      <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Arabic details') }}</label>
                        <input type="text" name="details_ar" value="{{ $product->details_ar }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product details">
                      </div>
                      @error('details_ar')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror

                      <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Brand') }}</label>
                        <select name="brand_id" class="form-control">
                            @foreach ($brand as $brand )
                            <option {{ old('brand_id')==$brand->id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name_en }}</option>
                            @endforeach
                          </select>                      </div>
                      @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror

                          <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('message.Sub Category') }}</label>
                            <select name="subcategory_id" id="subcategory"class="form-control">
                                @foreach ($subcategory as $subcategory )
                                <option {{ old('subcategory_id')==$subcategory->id ? 'selected' : '' }} value="{{ $subcategory->id }}">{{ $subcategory->name_en }}</option>
                                @endforeach
                              </select>
                          </div>
                          @error('subcategory_id')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror

                              <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('message.Offer ') }}</label>
                                <select name="offer_id" id="subcategory"class="form-control">
                                    @foreach ($offer as $offer )
                                    <option {{ old('subcategory_id')==$offer->id ? 'selected' : '' }} value="{{ $offer->id }}">{{ $offer->title_en }}</option>
                                    @endforeach
                                  </select>
                              </div>
                              @error('offer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                  @enderror

                              <div class="form-group">
                                <label for="exampleInputFile">{{ __('message.IMAGE') }}</label>
                                <div class="form-group" >
                                    <img src="{{ asset('images/product/'.$product->photo) }}" style="width: 10%">
                                </div>
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

           {{-- <div class="form-group">
            <label for="exampleInputFile">Category photo</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
         </div> --}}
{{--
              <div class="input-group-append">
                <span class="input-group-text">save</span>
              </div> --}}
            {{-- </div>
            @error('photo')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>
        </div> --}}
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection