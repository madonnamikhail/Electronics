@extends('layouts.dashboard')
@section('title','offer products')
@section('link')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}

@endsection
@section('content')
{{-- <a href="{{ asset('admin/product/create') }}" class="btn btn-success">Add</a> --}}
    <div class="col-12">
        <div class="col-12">
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
        </div>
        <table id="example2" class="table table-bordered table-hover">
            <thead>

            <tr>
              <th>{{ __('message.ID') }}</th>
              <th>{{ __('message.English Name') }}</th>
              <th>{{ __('message.Arabic Name') }}</th>
              <th>{{ __('message.price') }}</th>
              <th>{{ __('message.code') }}</th>
              <th>{{ __('message.English details') }}</th>
              <th>{{ __('message.Arabic details') }}</th>
              <th>{{ __('message.Brand') }}</th>
              <th>{{ __('message.sub Category') }}</th>
              <th>{{ __('message.IMAGE') }}</th>
              <th>{{ __('message.ACTION') }}</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                @foreach ($products as $products)
                <tr>
                    <td>{{ $i }} @php
                        $i++;
                    @endphp
                    </td>
                    <td>{{ $products->name_en }}</td>
                    <td>{{ $products->name_ar }}</td>
                    <td>{{ $products->price }}</td>
                    <td>{{ $products->code }}</td>
                    <td>{{ $products->details_en }}</td>
                    <td>{{ $products->details_ar }}</td>
                    <td>
                        @foreach ($brand as $brands)
                        @if ($products->brand_id == $brands->id)
                                {{ $brands->name_en }}
                        @endif
                     @endforeach
                    </td>
                    <td>
                        @foreach ($subcategorys as $subcategory)
                        @if ($products->subCategory_id == $subcategory->id)
                                {{ $subcategory->name_en }}
                        @endif
                     @endforeach

                    </td>
                    <td>
                        <img src="{{ asset('images/product/'.$products->photo) }}" style="width:30%;">
                    </td>
                    <td>
                        <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                            <a href="{{ route('edit.product' , $products->id) }}" class="btn btn-success">{{ __('message.Edit') }}</a>
                            <br>
                            {{-- <a href="{{ asset('admin/delete/'.$category->id) }}" class="btn btn-warning">Delete</a> --}}
                                <form method="post" action="{{route('delete.product.offer')}}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $products->id }}">
                                    <input type="hidden" name="photo" value="{{ $products->photo }}">
                                    <input type="hidden" name="offer_id" value="{{ $offer_id}}">
                                    <button class="btn btn-danger form-group  ">{{ __('message.Delete') }}</button>
                                </form>
                            <br>
                        </div>

                    </td>
                  </tr>
                @endforeach


            </tbody>

        </table>



            <form method="post" action="{{ route('offers.product.add') }}">
                @csrf
                <div class="card-body">
                    <label for="exampleInputEmail1">choose products</label>

                    <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.Product') }}</label>
                    <select name="products[]" class="form-control" multiple>
                        @foreach ($allproducts as $allproducts )
                            <option value="{{ $allproducts->id }}">{{ $allproducts->name_en }}</option>
                        @endforeach
                        </select>
                    </div>

                    <label for="exampleInputEmail1">choose offer</label>

                    <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('message.Offers') }}</label>
                    <select name="offers" id="subcategory"class="form-control">
                        @foreach ($alloffers as $alloffers )
                        <option value="{{ $alloffers->id }}">{{ $alloffers->title_en }}</option>
                        @endforeach
                        </select>
                    </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}</button>
                </div>
              </form>


    </div>


@endsection
@section('script')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
       $('#example2').DataTable({
         "paging": true,
         "lengthChange": false,
         "searching": false,
         "ordering": true,
         "info": true,
         "autoWidth": false,
         "responsive": true,
       });
    });
  </script>
@endsection


