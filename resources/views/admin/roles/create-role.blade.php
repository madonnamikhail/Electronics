@extends('layouts.dashboard')
@section('title','Create Role')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header bg-success">
        <h3 class="card-title">{{ __('message.New Role') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" action="{{ route('store.role') }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Name') }}</label>
            <input type="text" name="name"  value="{{ old('name') }}"class="form-control" id="exampleInputEmail1" placeholder="Enter Role name">
          </div>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">Gaurd</label>
            <select name="guard_name" class="form-control">
                @foreach ($guards as $guard )
                <option {{ old('guard_name')==$guard ? 'selected' : '' }} value="{{ $guard }}">{{ $guard }}</option>
                @endforeach
            </select>
          </div>
          @error('guard_name')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        
          <h4 class="bg-success" style="margin: 40px 0 20px;font-weight: 600;padding: 10px 10px 10px 20px;border-radius: 10px;">{{__('message.Permissions')}}: </h4>
          <div class="form-group" style="display: flex;flex-direction: row; flex-wrap:wrap; justify-content: space-between; width: 900px;margin: 0 auto;">
            @php
                $count=1;
            @endphp

            @foreach ($permissions as $all_permission)
              <div>
                <input type='checkbox' class="m-2" name='permission_id[]' value='{{ $all_permission->id }}'>&nbsp<label style="font-weight: 400;">{{ $all_permission->name }}</label>
              </div>
                @if ($count == 4)
                  <br> 
                  <div style="flex-basis: 100%; height: 0;"></div>
                  @php
                      $count=0;
                  @endphp 
                @endif
              @php
                  $count++;
              @endphp
            @endforeach
          </div>
          @error('permission_id[]')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>

@endsection
