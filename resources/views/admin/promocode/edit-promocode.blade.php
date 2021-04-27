@extends('layouts.dashboard')
@section('title','Edit PromoCode')


@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Promo Code') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('update.promocode',$promo->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Name') }}</label>
            <input type="text" name="name"  value="{{ $promo->name }}"class="form-control" id="exampleInputEmail1" placeholder="Enter name">
          </div>
          @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Discount Value') }} </label>
            <input type="text" name="discountValue" value="{{ $promo->discountValue }}" class="form-control" id="exampleInputEmail1" placeholder="Enter discount ">
          </div>
          @error('discountValue')
                <span class="text-danger">{{ $message }}</span>
              @enderror

                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.Min Order value') }}</label>
                    <input type="text" name="minOrderValue" value="{{ $promo->minOrderValue }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product english details">
                  </div>
                  @error('minOrderValue')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror

                      <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Max Order Value') }}</label>
                        <input type="text" name="maxOrderValue" value="{{ $promo->maxOrderValue }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product arabic details">
                      </div>
                      @error('maxOrderValue')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror



                          <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('message.Promocode Type') }}</label>
                            {{ 'old:'.old('type') .'<br>DB:'.$promo->type  }}
                              <select  name="type" id="type" class="form-control">

                                  <option {{ (old('type') !== NULL) ? ( ( old('type')==0)   ? 'selected' : '' ) : ($promo->type ==0 ? 'selected' : '') }} value="0" class="form-group">
                                      Fixed
                                  </option>
                                  {{-- ($promo->type ==0 ? 'selected' : '') --}}
                                  <option {{ (old('type') !== NULL) ? (( old('type')==1)   ? 'selected' : '' ) : ($promo->type ==1 ? 'selected' : '') }}  value="1" class="form-group">
                                      Percentage
                                  </option>
                                </select>
                          </div>

                    {{-- </div> --}}
                    @error('type')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror

                    <div class="form-group">
                      <label for="exampleInputEmail1">{{ __('message.Max Usage') }}</label>
                      <div>
                          <input type="number" name="max_usage" value="{{ $promo->max_usage }}">
                      </div>

                  </div>
                    @error('max_usage')
                          <span class="text-danger">{{ $message }}</span>
                  @enderror


                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.Max Usage Per User') }}</label>
                    <div>
                        <input type="number" name="max_usage_per_user" value="{{ $promo->max_usage_per_user }}">
                    </div>

                </div>
                  @error('max_usage_per_user')
                        <span class="text-danger">{{ $message }}</span>
                @enderror


                      <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Start Date') }}</label>
                        <div>
                            <input type="date" name="start_date" value="{{ $promo->start_date }}">
                        </div>

                    </div>
                      @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('message.Expire Date') }}</label>
                        <div>
                            <input type="date" name="expire_date" value="{{ $promo->expire_date }}">
                        </div>

                    </div>
                      @error('expire_date')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror

                    {{-- <div class="form-group">
                        <label for="exampleInputFile">Offer photo</label>
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
                      </div> --}}


        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>

@endsection
