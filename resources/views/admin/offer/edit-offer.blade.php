@extends('layouts.dashboard')
@section('title','Edit Offer')


@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Offer') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('update.offer',$offers->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.English Title') }}</label>
            <input type="text" name="title_en"  value="{{ $offers->title_en }}"class="form-control" id="exampleInputEmail1" placeholder="Enter offer english name">
          </div>
          @error('title_en')
                <span class="text-danger">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="exampleInputEmail1">{{ __('message.Arabic Title') }}</label>
                <input type="text" name="title_ar"  value="{{ $offers->title_ar }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Product arabic name">
              </div>
              @error('title_ar')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Discount Value') }}</label>
            <input type="text" name="discount" value="{{  $offers->discount  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter discount ">
          </div>
          @error('discount')
                <span class="text-danger">{{ $message }}</span>
              @enderror

                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.English Details') }}</label>
                    <input type="text" name="details_en" value="{{  $offers->details_en  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product english details">
                  </div>
                  @error('details_en')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror

                      <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Arabic Details') }}</label>
                        <input type="text" name="details_ar" value="{{  $offers->details_ar  }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product arabic details">
                      </div>
                      @error('details_ar')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror

                      <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Start Date') }}</label>
                        <div>
                            <input type="date" name="start_date" value={{  $offers->start_date  }}>
                        </div>

                    </div>
                      @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Expire Date') }}</label>
                        <div>
                            <input type="date" name="expire_date" value= {{ $offers->expire_date }} >
                        </div>

                    </div>
                      @error('expire')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                        <label for="exampleInputFile">{{ __('message.IMAGE') }}</label>
                        <div class="form-group" >
                            <img src="{{ asset('images/offers/'.$offers->photo) }}">
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
                      </div>


        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
        </div>
      </form>
    </div>

@endsection
