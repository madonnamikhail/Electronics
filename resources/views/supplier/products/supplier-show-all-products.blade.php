@extends('layouts.Supplier-dashboard')
@section('title','all products')
@section('link')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2196F3;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
  </style>
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
        <form action="{{ route('update-product-status') }}" method="post" id='status_product_form'>
          @csrf
          <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>{{ __('message.ID') }}</th>
                  <th>{{ __('message.English Name') }}</th>
                  <th>{{ __('message.Arabic Name') }}</th>
                  <th>{{ __('message.price') }}</th>
                  <th>{{ __('message.code') }}</th>
                  <th>{{ __('message.id') }}</th>
                  <th>{{ __('message.status') }}</th>
                  <th>{{ __('message.English details') }}</th>
                  <th>{{ __('message.Arabic details') }}</th>
                  <th>{{ __('message.Brand') }}</th>
                  <th>{{ __('message.Sub Category') }}</th>
                  <th>{{ __('message.IMAGE') }}</th>
                  <th>{{ __('message.ACTION') }}</th>
                </tr>
                </thead>

                <tbody>
                    <td>
                        <div class="test">

                    </div>
                    </td>

                    @php
                        $i=1;
                    @endphp
                    @foreach ($products->products as $products)
                    {{ $products->id }}
                    <tr>
                        <td>{{ $i }}
                            @php $i++; @endphp
                        </td>
                        <td>{{ $products->name_en }}</td>
                        <td>{{ $products->name_ar }}</td>
                        <td>{{ $products->price }}</td>
                        <td>{{ $products->code }}</td>
                        <td>{{ $products->id }}</td>
                        <td>

                          @if($products->status == 1)
                          {{ $products->id }}
                            <label class="switch">
                              <input type="checkbox" class="check" id="" checked name="status" value="0" product_id="{{ $products->id}}">
                              <span class="slider round"></span>
                            </label>
                            @endif
                          @if($products->status == 0)
                          {{ $products->id }}
                            <label class="switch">
                              <input type="checkbox" class="check" id="product_status" name="status" value="1" product_id="{{ $products->id}}">
                              <span class="slider round"></span>
                            </label>
                          @endif
                        </td>
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
                              <a href="{{ route('supplier.edit.product',$products->id) }}" class="btn btn-success"><i class="fas fa-user-edit"></i></a>
                                    {{-- <form method="post" action="{{route('supplier.delete.product')}}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $products->id }}">
                                        <input type="hidden" name="photo" value="{{ $products->photo }}">
                                        <button class="btn btn-danger form-group"><i class="fas fa-trash-alt"></i></button>
                                    </form> --}}
                                <br>
                            </div>

                        </td>

                      </tr>
                    @endforeach
                </tbody>
            </table>
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

  <script>
    // product_status
    $(document).ready(function(){
            $(document).on('click','.check', function(event){
              event.preventDefault();
            //   $('#status_product_form').submit();
                let token = $('meta[name="csrf-token"]').attr('content');
                let product_id = $(this).attr('product_id');
                let status = $(this).val();
                // alert("product id = " + product_id +" status " + status);
                $.ajax({
                    method: 'POST',
                    url: '{{route('update-product-status')}}',
                    dataType: 'text',
                    data: {
                    _token : token ,
                    product_id: product_id,
                    status:status
                    },
                    success: function (data) {
                        // $('.test').append(data);
                        location.reload();
                    },
                });
            });
        });
  </script>
@endsection


