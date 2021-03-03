@extends('layouts.site')
@section('title','Product Rating')
@section('content')
    <div class="col-12">
        <div class="breadcrumb-area bg-image-3 ptb-150">
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>Product RATING</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Product RATING </li>
                    </ul>
                </div>
            </div>
        </div>
		<!-- Breadcrumb Area End -->
         <!-- shopping-cart-area start -->
        <div class="cart-main-area ptb-100">
            <div class="container">
                <h3 class="page-title">Your Products</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-content table-responsive wishlist">
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
                                    <table>
                                        <thead>
                                           <tr>
                                                <th colspan="8">Order ID: {{ $order_id }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                                @foreach ($products as $product)
                                                    @foreach ($product_data as $id)
                                                        @if ($product->id == $id)
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                {{-- <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                <input type="hidden" name="user_id" value="{{ $user_id }}"> --}}
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
                                                            <td>
                                                                <form method="post" action="{{ route('insert') }}" name="rating">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                                                                    <input type="number" name="value" placeholder="Rate this product from 1:5">
                                                                    <textarea row="2" col="4" name="comment" placeholder="Enter your comment"></textarea>
                                                                    <button type="submit">Review This Product</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                            @endforeach
                                            @php
                                                $i++;
                                            @endphp
                                    </tbody>
                                </table>
                            </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
