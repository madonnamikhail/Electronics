@extends('layouts.site')
@section('title','Order Rating')
@section('content')
    <div class="col-12">
        <div class="breadcrumb-area bg-image-3 ptb-150">
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>ORDER RATING</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">ORDER RATING </li>
                    </ul>
                </div>
            </div>
        </div>
		<!-- Breadcrumb Area End -->
         <!-- shopping-cart-area start -->
        <div class="cart-main-area ptb-100">
            <div class="container">
                <h3 class="page-title">Your orders</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        @foreach($orders as $order)
                            <form action="#">
                                <div class="table-content table-responsive wishlist">
                                    <table>
                                        <thead>
                                           <tr>
                                                <th colspan="2">Order ID: {{$order->id}}</th>
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
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td class="product-thumbnail">
                                                        <a href="#"><img style="width: 30%" src="{{ asset('images\product\\'.$product->photo) }}" alt=""></a>
                                                    </td>
                                                    <td class="product-name"><a href="#">{{ $product->name_en }}</a></td>
                                                    <td class="product-price-cart"><span class="amount">{{  }}</span></td>
                                                    
                                                    <td class="product-wishlist-cart">
                                                        <a href="#">add to cart</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        
                                    </tbody>
                                    <thead>
                                        <th colspan="4"><button>Review This Order</button></th>
                                    </thead>
                                </table>
                            </div>
                        </form>
                        <br><br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection