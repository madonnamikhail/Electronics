@extends('layouts.site')
@section('title', 'Cart')

@section('content')

<div class="breadcrumb-area bg-image-3 ptb-150">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h3>CART PAGE</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Cart page</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->
 <!-- shopping-cart-area start -->
<div class="cart-main-area ptb-100">
    <div class="container">
        <h3 class="page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                {{-- <form action="#"> --}}
                    <div class="table-content table-responsive">
                        <table>
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
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @if ($product->user_id == $user_id)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="#"><img style="width:50%" src="{{ asset('images\product\\'. $product->product_photo ) }}" alt=""></a>
                                        </td>
                                        <td class="product-name"><a href="#">{{ $product->name_en }} </a></td>

                                        <td class="product-price-cart"><span class="amount">
                                            @if ($product->discount)
                                                {{ $product->price_after_discount }}
                                            @else
                                                {{ $product->price }}
                                            @endif
                                            
                                        </span></td>
                                        <td class="product-quantity">
                                            <div class="pro-dec-cart">
                                                <p class="cart-plus-minus-box">{{ $product->quantity }}</p>
                                            </div>
                                        </td>
                                        <td class="product-remove">
                                            <a href="{{ route('cart.product.edit', $product->product_id) }}"><i class="fa fa-pencil"></i></a>
                                            <form action="{{ route('cart.product.delete') }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                                <button style="display: contents;" type="submit"><a><i class="fa fa-times"></i></a></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="{{ route('index.page') }}">Continue Shopping</a>
                                </div>
                                <div class="cart-shiping-update">
                                    <a href="{{ route('get.cart.total') }}">proceed to checkout</a>
                                </div>
                                <div class="cart-clear cart-shiping-update">
                                    {{-- <button>Update Shopping Cart</button> --}}
                                    <a>
                                        <form action="{{ route('cart.clear') }}" method="post">
                                            @csrf
                                            {{-- @method('delete') --}}
                                            <button type="sumbit">Clear Shopping Cart</button>
                                        </form>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection
