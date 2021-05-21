@extends('layouts.dashboard')
@section('title','order Products')
@section('link')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
@endsection
@section('content')
<a href="{{ asset('admin/product/create') }}" class="btn btn-success">{{ __('message.Add') }}</a>
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
              <th>{{ __('message.Qty') }}</th>
              <th>{{ __('message.offer') }}</th>
              <th>{{ __('message.Price After Offer') }}</th>

              <th>{{ __('message.Status') }}</th>
              {{-- <th>{{ __('message.English Details') }}</th>
              <th>{{ __('message.Arabic Details') }}</th>
              <th>{{ __('message.IMAGE') }}</th> --}}
              <th>{{ __('message.Brand') }}</th>
              {{-- <th>{{ __('message.Sub Category') }}</th> --}}
              <th>{{ __('message.Supplier') }}</th>
              <th>{{ __('message.ACTION') }}</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                    $j=1;
                @endphp
                @foreach ($order_Products->products as $product)
                     <tr>

                        <td>{{ $i }} @php
                                $i++;
                            @endphp
                        </td>
                        <td>{{ $product->name_en }}</td>
                        <td>{{ $product->name_ar }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>
                            @foreach ($offers as $offer)
                                @if ($product->pivot->offer_id == $offer->id)
                                        {{ $offer->title_en }}
                                @endif

                        @endforeach
                        </td>
                        <td>{{ $product->pivot->price_after_offer_discount }}</td>
                        <td>{{ $product->pivot->status }}</td>  
                        {{-- <td>{{ $product->details_en }}</td>
                        <td>{{ $product->details_ar }}</td>
                        <td>
                            <img src="{{ asset('images/product/'.$product->photo) }}" style="width:30%;">
                        </td> --}}
                        <td>
                            @foreach ($brand as $brands)
                            @if ($product->brand_id == $brands->id)
                                    {{ $brands->name_en }}
                            @endif
                        @endforeach
                        </td>
                        {{-- <td>
                            @foreach ($subcategorys as $subcategory)
                            @if ($product->subCategory_id == $subcategory->id)
                                    {{ $subcategory->name_en }}
                            @endif
                        @endforeach
                        </td> --}}
                        <td>

                            @foreach ($suppliers as $supplier)
                            @if ($product->supplier_id == $supplier->id)
                                    {{ $supplier->name_en }}
                            @endif
                        @endforeach

                        </td>
                        <td>
                          @if ($product->pivot->status == 0)
                              <a href="{{ route('appologize',['product_id'=>$product->id,'user_id'=>$user_id, 'order_id'=>$product->pivot->order_id]) }}" class="btn btn-danger">Appologize to User</a>
                          @endif
                        </td>
                    </tr>
                @endforeach


            </tbody>
          </table>
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


