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
      <form method="post" action="{{ asset('admin/product/store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Product Name</label>
            <input type="text" name="name"  value="{{ old('name') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Product  name">
          </div>
          @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">Product Price </label>
            <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Price">
          </div>
          @error('price')
                <span class="text-danger">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="exampleInputEmail1">Product code </label>
                <input type="text" name="code" value="{{ old('code') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product code">
              </div>
              @error('code')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror

                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Details </label>
                    <input type="text" name="details" value="{{ old('details') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product details">
                  </div>
                  @error('details')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror

                      <div class="form-group">
                        <label for="exampleInputEmail1">Brand</label>
                        <select name="brand_id" class="form-control">
                            @foreach ($brand as $brand )
                            <option {{ old('brand_id')==$brand->id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                          </select>                      </div>
                      @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror

                          <div class="form-group">
                            <label for="exampleInputEmail1">SubCategory</label>
                            <select name="subcategory_id" id="subcategory"class="form-control">
                                @foreach ($subcategory as $subcategory )
                                <option {{ old('subcategory_id')==$subcategory->id ? 'selected' : '' }} value="{{ $subcategory->id }}">{{ $subcategory->name_en }}</option>
                                @endforeach
                              </select>
                          </div>
                          @error('subcategory_id')
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
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>

@endsection
