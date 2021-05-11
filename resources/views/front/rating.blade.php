@extends('layouts.site')
@section('title','Order Rating')
@section('content')
    <div class="col-12">
        {{-- <div class="breadcrumb-area bg-image-3 ptb-150"> --}}
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>ORDER RATING</h3>
                    <ul>
                        <li><a style="color: black;" href="{{ route('index.page') }}">Home</a></li>
                        <li style="color: black;" class="active">ORDER RATING </li>
                    </ul>
                </div>
            </div>
        {{-- </div> --}}
		<!-- Breadcrumb Area End -->
         <!-- shopping-cart-area start -->
        {{-- <div class="cart-main-area ptb-100">
            <div class="container">
                <h3 class="page-title">Your orders</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            @forelse($orders as $order)
                                <form action="{{ route('product.rating') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-content table-responsive wishlist">
                                        <table>
                                            <thead>
                                            <tr>
                                                    <th colspan="2">Order ID: {{$order->id}}</th>
                                                    <input type="hidden" value="{{$order->id}}" name="order_id">
                                                    @switch($order->status)
                                                        @case(0)
                                                            <th colspan="2">Order Status: Created</th>
                                                            @break
                                                        @case(1)
                                                            <th colspan="2">Order Status: In Progress</th>
                                                            @break
                                                        @case(2)
                                                            <th colspan="2">Order Status: Delivered</th>
                                                            @break
                                                        @default
                                                    @endswitch
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=0;
                                                @endphp

                                                    @foreach ($order->products as $product)
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <input type="hidden" name="id[]" value="{{ $product->id }}">
                                                                <a href="#"><img style="width: 30%" src="{{ asset('images\product\\'.$product->photo) }}" alt=""></a>
                                                            </td>
                                                            <td class="product-name"><a href="#">{{ $product->name_en }}</a></td>
                                                            <td class="product-price-cart"><span class="amount">
                                                                @foreach ($suppliers as $supplier)
                                                                    @if ($supplier->id ==$product->supplier_id)
                                                                    Sold By: <br> {{ $supplier->name_en }}

                                                                    @endif
                                                                @endforeach
                                                            </span></td>
                                                            <td>QTY: <br>{{ $product->pivot->quantity }}</td>
                                                        </tr>
                                                    @endforeach
                                                    @php
                                                        $i++;
                                                    @endphp


                                        </tbody>
                                        <thead>

                                            <th colspan="4">
                                                @if ($order->status==2)
                                                    <button type="submit">Review This Order</button>
                                                @else
                                                    <p style="color :red">Your order hasnot been derliverd yet ! </p>
                                                @endif
                                            </th>
                                        </thead>
                                    </table>
                                </div>
                            </form>
                            <br><br>
                        @empty
                            <div class="alert alert-danger"> there are no orders yet !</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div> --}}


        {{------------------------------------------------------------------------------------------------------------------------------------------}}
        @forelse($orders as $order)
        <div class="panel panel-default m-5">
            <div class="panel-heading">
                <h5 class="panel-title"><a data-toggle="collapse" data-parent="#faq" href="#{{$order->id}}">Order ID: {{$order->id}} &nbsp;&nbsp;&nbsp;&nbsp;
                    @switch($order->status)
                        @case(0)
                            <th colspan="2">Order Status: Created</th>
                            @break
                        @case(1)
                            <th colspan="2">Order Status: In Progress</th>
                            @break
                        @case(2)
                            <th colspan="2">Order Status: Delivered</th>
                            @break
                        @default
                    @endswitch
                </a></h5>
            </div>   {{--  --}}
            <div id="{{$order->id}}" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="billing-information-wrapper">
                        <div class="row">
                            {{--- Table Body ----}}
                            <form action="{{ route('product.rating') }}" method="get" enctype="multipart/form-data">
                                @csrf
                                <div class="table-content table-responsive wishlist">
                                    <table>
                                        <tbody>
                                                @foreach ($order->products as $product)
                                                    {{-- @foreach ($products as $product)
                                                            {{ $product->id }}
                                                    @endforeach --}}
                                                    <tr>
                                                        <td class="product-thumbnail">
                                                            <input type="hidden" name="id[]" value="{{ $product->id }}">
                                                            <a href="#"><img style="width: 30%" src="{{ asset('images\product\\'.$product->photo) }}" alt=""></a>
                                                        </td>
                                                        <td class="product-name"><a href="#">{{ $product->name_en }}</a></td>
                                                        <td class="product-price-cart"><span class="amount">
                                                            @foreach ($suppliers as $supplier)
                                                                @if ($supplier->id ==$product->supplier_id)
                                                                Sold By: <br> {{ $supplier->name_en }}

                                                                @endif
                                                            @endforeach
                                                        </span></td>
                                                        <td>QTY: <br>{{ $product->pivot->quantity }}</td>
                                                        {{-- <td class="product-wishlist-cart">
                                                            <a href="#">add to cart</a>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                    </tbody>
                                    <thead>

                                        <th colspan="4">
                                            @if ($order->status==2)
                                                <button type="submit">Review This Order</button>
                                            @else
                                                <p style="color :red">Your order hasnot been derliverd yet ! </p>
                                            @endif
                                        </th>
                                    </thead>
                                </table>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="alert alert-danger"> there are no orders yet !</div>
        @endforelse
        {{------------------------------------------------------------------------------------------------------------------------------------------}}


    </div>
@endsection
