@extends('layouts.dashboard')
@section('title', 'ُEdit Address')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.Edit Address') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('update.address', $address->id) }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Flat Number') }}</label>
            <input type="number" name="flat" class="form-control" value="{{ $address->flat }}" id="exampleInputEmail1" placeholder="Enter flat number">
          </div>
          @error('flat')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Building Number') }}</label>
            <input type="number" name="building" value="{{ $address->building }}" class="form-control" id="exampleInputEmail1" placeholder="Enter building number">
          </div>
          @error('building')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Floor Number') }}</label>
            <input type="number" name="floor" value="{{ $address->floor }}" class="form-control" id="exampleInputEmail1" placeholder="Enter floor number">
          </div>
          @error('floor')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Street English Name') }}</label>
            <input type="text" name="street_en" value="{{ $address->street_en }}" class="form-control" id="exampleInputEmail1" placeholder="Enter street english name">
          </div>
          @error('street_en')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Street Arabic Name') }}</label>
            <input type="text" name="street_ar" value="{{ $address->street_ar }}" class="form-control" id="exampleInputEmail1" placeholder="Enter street arabic name">
          </div>
          @error('street_ar')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputFile">{{ __('message.Choose Region') }}</label>
            <select name="region_id" class="form-control">
              @foreach ($regions as $region )
              {{-- {{ old('region_id')==$region->id ? 'selected' : '' }} --}}
              <option {{ $address->region_id==$region->id ? 'selected' : '' }} value="{{ $region->id }}">{{ $region->name_en }}</option>
              @endforeach
            </select>
            @error('region_id')
            <span class="text-danger">{{ $message }}</span>
          @enderror
          </div>

          <div class="form-group">
            <label for="exampleInputFile">{{ __('message.Choose User') }}</label>
            <select name="user_id" class="form-control">
              @foreach ($users as $user )
              <option {{ $address->region_id==$region->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
            @error('user_id')
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
