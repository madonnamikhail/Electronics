@extends('layouts.dashboard')
@section('title','all Orders')
@section('link')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
@endsection
@section('content')
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
              <th>{{ __('message.Status') }}</th>
              <th>{{ __('message.Amount') }}</th>
              <th>{{ __('message.Total Price') }}</th>
              <th>{{ __('message.Promocode') }}</th>
              <th>{{ __('message.Total Price After Promocode') }}</th>
              <th>{{ __('message.User Name') }}</th>
              <th>{{ __('message.ACTION') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        @if ($order->status == 0)
                             {{ "Order Created"}}
                        @elseif($order->status == 1)
                                {{ "Order is In Progress"}}
                        @elseif($order->status == 2)
                            {{ "Deliverd"}}
                        @endif
                    </td>

                    <td>{{ $order->amount }}</td>
                    <td>{{ $order->total_price }}</td>

                    <td>
                        @if ($order->promoCodes_id == 0)
                        {{ "There is no promocode"}}
                        @else
                            {{ $order->promoCodes_id  }}
                        @endif
                    </td>
                    <td>{{ $order->total_price_after_promocode }}</td>
                    <td>
                        @foreach ($users as $user)
                        @if ($order->user_id == $user->id)
                                {{ $user->name}}
                        @endif
                    @endforeach
                    </td>
                    <td>
                        {{-- @php
                        id,date,stus,prodcuts
                        $status = array_column($order->porducts,'status');
                        
                        @endphp --}}
                        {{-- @endphp --}}
                        @php
                            $x=1;
                            $y=2;
                        @endphp
                        @php
                            $product_status = DB::select("SELECT
                                sum(case when `order_product`.`status` = 1 then 1 else 0 end) AS `onee`,
                                sum(case when `order_product`.`status` = 2 then 1 else 0 end) AS `twoo`,
                                sum(case when `order_product`.`status` = 0 then 1 else 0 end) AS `zeroo`,
                                sum(case when `order_product`.`status` is null then 1 else 0 end) AS `nulll`
                            FROM
                                `order_product`
                            JOIN `orders` ON `orders`.`id` = `order_product`.`order_id`
                            WHERE
                                `orders`.`id` = $order->id");
                            echo $total_num_product = $product_status[0]->onee + $product_status[0]->zeroo + $product_status[0]->nulll . "<br>";
                            echo $product_status[0]->twoo . "<br>";
                            echo $product_status[0]->onee . "<br>";
                            echo $product_status[0]->zeroo . "<br>";
                            echo $product_status[0]->nulll;
                            // $order_product_status=App\Models\Order::with('products')->find($order->id);
                            //         echo count($order_product_status->products) . "<br>";
                                // foreach($order_product_status->products as $productStatus){
                                    // echo mb_strlen($productStatus->pivot->status) ;
                                    // if(is_null($productStatus->pivot->status)){
                                    //     echo "supllier has no response on the product status fro this order";
                                    // }elseif($productStatus->pivot->status == 1){
                                    // }
                                    // echo $productStatus;
                                        // echo count((array)$productStatus->id);
                                    // var_dump($productStatus->pivot->status);
                                // }
                        @endphp
                        <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                            @if ($product_status[0]->onee == $total_num_product)
                                <a href="{{ route('update.order',['id'=>$order->id,'action'=>$x]) }}" class="btn btn-success">{{ __('message.In Progress') }}</a>
                            @elseif ($product_status[0]->twoo && $product_status[0]->zeroo == 0 && $product_status[0]->nulll == 0)
                                <a href="{{ route('update.order',['id'=>$order->id,'action'=>$x]) }}" class="btn btn-success">{{ __('message.In Progress') }}</a>  
                            @elseif ($product_status[0]->twoo == $total_num_product)
                                <div class="bg-warning">
                                    <p>
                                        <i class="fas fa-heart-broken"></i> &nbsp
                                        Nothing has been delievered
                                    </p>
                                </div>  
                            @elseif($product_status[0]->zeroo)
                                <a href="{{ route('order.product',['id'=>$order->id, 'user_id'=>$order->user_id]) }}" class="btn btn-success"><i class="fas fa-exclamation" style="color: red"></i> &nbsp {{ __('message.show products') }}</a>
                            @elseif($product_status[0]->nulll)
                                <a href="{{ route('order.product',['id'=>$order->id, 'user_id'=>$order->user_id]) }}" class="btn btn-success"><i class="fas fa-exclamation" style="color: yellow"></i> &nbsp {{ __('message.show products') }}</a>
                            @endif
                            {{-- <a href="{{ route('order.product',$order->id) }}" class="btn btn-success">{{ __('message.show products') }}</a> --}}

                            
                            <br>
                            {{-- <a  href="{{ route('update.order',['id'=>$order->id,'action'=>$y]) }}" class="btn btn-success">{{ __('message.Done') }}</a> --}}
                            <br>
                                <form method="post" action="{{route('delete.order')}}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                    <button class="btn btn-danger form-group  ">{{ __('message.Delete') }}</button>
                                </form>
                            <br>
                        </div>

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


