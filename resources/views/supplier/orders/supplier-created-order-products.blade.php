@extends('layouts.Supplier-dashboard')
@section('title','order Products')
@section('link')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
@endsection
@section('content')
    <div class="col-12">
      <h2>CReated Orders</h2>
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
              <th>{{ __('message.order_ID') }}</th>
              <th>{{ __('message.English Name') }}</th>
              <th>{{ __('message.Arabic Name') }}</th>
              <th>{{ __('message.price') }}</th>
              <th>{{ __('message.code') }}</th>
              <th>{{ __('message.English Details') }}</th>
              <th>{{ __('message.Arabic Details') }}</th>
              <th>{{ __('message.IMAGE') }}</th>
              <th>{{ __('message.Brand') }}</th>
              <th>{{ __('message.Sub Category') }}</th>
              <th>{{ __('message.ACTION') }}</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                    $j=1;
                @endphp
                @forelse ($orders as $order)
                  @foreach ($order->products as $product)
                    @if ($product->supplier_id == Auth::user()->id)
                        <tr>
                            <td>{{ $i }} @php
                                    $i++;
                                @endphp
                            </td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $product->name_en }}</td>
                            <td>{{ $product->name_ar }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->details_en }}</td>
                            <td>{{ $product->details_ar }}</td>
                            <td>
                                <img src="{{ asset('images/product/'.$product->photo) }}" style="width:30%;">
                            </td>
                            <td>
                                @foreach ($brand as $brands)
                                @if ($product->brand_id == $brands->id)
                                        {{ $brands->name_en }}
                                @endif
                            @endforeach
                            </td>
                            <td>
                                @foreach ($subcategorys as $subcategory)
                                @if ($product->subCategory_id == $subcategory->id)
                                        {{ $subcategory->name_en }}
                                @endif
                            @endforeach
                            </td>
                            <td>
                              @if (is_null($product->pivot->status))
                                <a href="{{ route('supplier.can.deliver',['product_id'=>$product->id,'order_id'=>$order->id]) }}" class="btn btn-success" title="can deliver"><i class="fas fa-truck"></i></a><br>
                                <a href="{{ route('supplier.cannot.deliver',['product_id'=>$product->id,'order_id'=>$order->id]) }}" class="btn btn-danger" title="cannot deliver"><i class="fas fa-trash-alt"></i></a> 
                              @elseif($product->pivot->status == 1)
                                <p class="alert alert-success">The product will be delivered</p>
                                <a href="{{ route('supplier.cannot.deliver',['product_id'=>$product->id,'order_id'=>$order->id]) }}" class="btn btn-danger" title="cannot deliver"><i class="fas fa-trash-alt"></i></a> 
                              @elseif($product->pivot->status == 0)
                                <p class="alert alert-danger">The product willnot be delivered</p>
                                <a href="{{ route('supplier.can.deliver',['product_id'=>$product->id,'order_id'=>$order->id]) }}" class="btn btn-success" title="can deliver"><i class="fas fa-truck"></i></a>
                              @endif
                            </td>
                        </tr>
                    @endif
                      
                  @endforeach
                @empty
                    
                @endforelse
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


