@extends('layouts.dashboard')
@section('title', 'Select User')
@section('content')
    <div class="col-lg-12">
        <form action="{{ route('select.user') }}" method="post">
            @csrf
            <div class="form-group">
                <label>{{ __('message.Select User') }}</label>
                <select class="user" id="user" name="user_id">
                  <option value="0" selected disabled>
                    {{ __('message.Select User') }}
                  </option>
                  @foreach ($users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ __('message.Select') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('message.Try') }}</button>

              </div>
        </form>
    </div>
@endsection
