@extends('layouts.dashboard')
@section('title','Edit Role')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header bg-warning">
        <h3 class="card-title">{{ __('message.Edit Role') }}</h3>
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
      <form method="post" action="{{ route('update.role.permissions',$role->id) }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Role Name') }}</label>
            <input type="text" name="name" value="{{$role->name}}" class="form-control" id="exampleInputEmail1" placeholder="Edit Role Name">
          </div>
          @error('name')
            <span class="text-danger">{{ $message }}</span>
          @enderror

          <div class="form-group">
            <label for="exampleInputEmail1">{{ __('message.Guard') }}</label>
            <select name="guard_name" class="form-control">
                @foreach ($guards as $guard )
                <option {{ $role->guard_name==$guard ? 'selected' : '' }} value="{{ $guard }}">{{ $guard }}</option>
                @endforeach
            </select>
            </div>
            @error('guard_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <h4 class="bg-warning" style="margin: 40px 0 20px;font-weight: 600;padding: 10px 10px 10px 20px;border-radius: 10px;">{{__('message.Permissions')}}: </h4>
            <div class="form-group" style="display: flex;flex-direction: row; flex-wrap:wrap; justify-content: space-between; width: 900px;margin: 0 auto;">
              @php
                  $count=1;
              @endphp

              @foreach ($all_permissions as $all_permission)
                <div>
                  <input id="permission_{{$all_permission->id}}" type='checkbox' class="m-2" {{ $role->hasPermissionTo($all_permission->name) ? 'checked' : '' }} name='permission_id[]' value='{{ $all_permission->id }}'>&nbsp<label for="permission_{{$all_permission->id}}" style="font-weight: 400;">{{ $all_permission->name }}</label>
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
          <button type="submit" class="btn btn-warning">{{ __('message.Edit') }}</button>
        </div>
      </form>
    </div>

@endsection
