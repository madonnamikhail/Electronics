@extends('layouts.dashboard')
@section('title','SubCategories')
@section('content')
<a href="{{ asset('admin/subcat/create') }}" class="btn btn-success">Add</a>
<table id="example2" class="table table-bordered table-hover">
    <thead>
    <tr>
      <th>ID</th>
      <th>English Name</th>
      <th>Arabic Name</th>
      <th>category ID</th>
      <th>IMAGE</th>
      <th>ACTION</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($sub as $subs)
        <tr>
            <td>{{ $subs->id }}</td>
            <td>{{ $subs->name_en}}</td>
            <td>{{ $subs->name_ar}}</td>
            <td>{{ $subs->category_id }}</td>
            <td>
                <img src="{{ asset('images/subcategorys/'.$subs->photo) }}" style="width:10%;">
            </td>
            <td>
                <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                    <div>
                        <a href="{{ asset('admin/subcat/edit/'.$subs->id) }}" class="btn btn-success">Edit</a>
                    <div>
                        <br>
                    <div>
                        <form method="post" action="{{asset('admin/subcat/delete')}}">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $subs->id }}">
                            <input type="hidden" name="photo" value="{{ $subs->photo }}">
                            <button class="btn btn-danger form-group  ">Delete</button>
                        </form>
                         <div>
                    <div>
                        <a href="{{ asset('admin/product/show/'.$subs->id) }}" class="btn btn-warning">show Products</a>

                    </div>


                </div>

            </td>
          </tr>
        @endforeach


    </tbody>
  </table>
@endsection
