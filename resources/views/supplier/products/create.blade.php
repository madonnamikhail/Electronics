@extends('layouts.dashboard')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Product</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('supplier.store.product') }}" enctype="multipart/form-data">
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
            <label for="exampleInputEmail1">{{ __('message.Price') }}</label>
            <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Price">
          </div>
          @error('price')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.code') }} </label>
            <input type="text" name="code" value="{{ old('code') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product code">
          </div>
          @error('code')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Details') }} </label>
            <input type="text" name="details_en" value="{{ old('details_en') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product english details">
          </div>
          @error('details_en')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Arabic Details') }} </label>
            <input type="text" name="details_ar" value="{{ old('details_ar') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product arabic details">
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
              </select>                     
          </div>
          @error('brand_id')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Sub Category') }}</label>
                <div class="form-group">
                    <select  name="subcategory_id" id="subcategory_id" class="form-control">
                        @foreach ($category as $category )
                                <optgroup label="{{ $category->name_en }}">
                                    @foreach ($subcategory as $subcategoryss)
                                        @if ($subcategoryss->category_id == $category->id)
                                            <option value="{{ $subcategoryss->id }}" class="form-group">
                                                {{-- @php
                                                    echo $subcategoryss->name_en;
                                                @endphp --}}
                                                {{ $subcategoryss->name_en }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                        @endforeach
                      </select>
                </div>
          </div>
          @error('subcategory_id')
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

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
    </form>
  </div>

@endsection
