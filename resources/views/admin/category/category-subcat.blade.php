@extends('layouts.dashboard')
@section('title','SubCategories')
@section('content')
<a href="{{ asset('admin/subcat/create') }}" class="btn btn-success">Add</a>
<table id="example2" class="table table-bordered table-hover">
    <thead>
    <tr>
      <th>{{ __('message.ID') }}</th>
      <th>{{ __('message.NAME') }}</th>
      <th>{{ __('message.category ID') }}</th>
      <th>{{ __('message.IMAGE') }}</th>
      <th>{{ __('message.ACTION') }}</th>
    </tr>
    </thead>
    <tbody>
        @php
            $i=0;
        @endphp
        @foreach ($sub as $subs)
        <tr>
            <td>{{ $subs->id }}</td>
            <td>{{ $subs->name}}</td>
            <td>
                    @foreach ($category as $categorys)
                        @if ($subs->category_id == $categorys->id)
                                {{ $categorys->name_en }}
                        @endif
                    @endforeach
            </td>
            <td>
                <img src="{{ asset('images/subcategorys/'.$subs->photo) }}" style="width:10%;">
            </td>
            <td>
                <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                    <div>
                        <a href="{{ route('edit.subcategory',$subs->id) }}" class="btn btn-success">{{ __('message.Edit') }}</a>
                    <div>
                        <br>
                    <div>
                        <form method="post" action="{{route('delete.subcategory')}}">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $subs->id }}">
                            <input type="hidden" name="photo" value="{{ $subs->photo }}">
                            <button class="btn btn-danger form-group  ">{{ __('message.Delete') }}</button>
                        </form>
                         <div>
                    <div>
                        <a href="{{ asset('admin/product/show/'.$subs->id) }}" class="btn btn-warning">{{ __('message.show Products') }}</a>

                    </div>


                </div>

            </td>
          </tr>
        @endforeach


    </tbody>
  </table>
@endsection
