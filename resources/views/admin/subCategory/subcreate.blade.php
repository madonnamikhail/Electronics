@extends('layouts.dashboard')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Sub Category</h3>
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
      <form method="post" action="{{ route('store.subcategory') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Sub-Category English Name</label>
            <input type="text" name="name_en"  value="{{ old('name_en') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Sub-category english name">
          </div>
          @error('name_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">Sub-Category Arabic  Name</label>
            <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter sub-category Arabic name">
          </div>
          @error('name_ar')
                <span class="text-danger">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="exampleInputEmail1">choose Categiry ID</label>
                <select name="category_id" class="form-control">
                    @foreach ($categorys as $cat )
                    <option {{ old('category_id')==$cat->id ? 'selected' : '' }} value="{{ $cat->id }}">{{ $cat->name_en }}</option>
                    @endforeach
                  </select>
                </div>
              @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror

          <div class="form-group">
            <label for="exampleInputFile">Category photo</label>
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
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>

@endsection
