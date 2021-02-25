@extends('layouts.site')
@section('titile','Total')
@section('content')
<div class="col-12" style="margin:20px auto ; ">
    <div class="col-lg-12 col-md-12">
        <div class="grand-totall" >
            <div class="title-wrap">
                <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
            </div>
            <form method="post" action="{{ route('place.order') }}" enctype="multipart/form-data">
                @csrf
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
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($products as $product)
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img style="width:20%" src="{{ asset('images\product\\'. $product->photo ) }}" alt=""></a>
                                    </td>
                                    <input type="hidden" name="photo[]" value="{{ $product->photo }}">
                                    <td class="product-name"><a href="#">{{ $product->name_en }} </a></td>
                                    <input type="hidden" name="name[]" value="{{ $product->name_en }}">
                                    <td class="product-price-cart"><span class="amount">{{ $product->price }}</span></td>
                                    <input type="hidden" name="price[]" value="{{ $product->price }}">

                                    <td class="product-quantity">
                                        <div class="pro-dec-cart">
                                            <p class="cart-plus-minus-box">{{ $product->pivot->quantity }}</p>
                                            <input type="hidden" name="quantity[]" value="{{ $product->pivot->quantity }}">

                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            echo $productPrice[$i];
                                        @endphp
                                        <input type="hidden" name="productPrice[]" value="@php  echo $productPrice[$i]; $i++;@endphp">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5>{{ __('message.Net Total Price') }} <span>
                        @php
                           $sum= array_sum($productPrice);
                           echo $sum;
                        @endphp
                        EGP
                    </span></h5>
                    <div class="total-shipping">
                        <h5>{{ __('message.Payment Method') }}</h5>
                        <ul>
                            <li>
                            <input type="radio" id="female" name="method_payment" value="0.9">
                            <label for="female">{{ __('message.Master Card') }} <span>&nbsp; &nbsp;( 10% Discount ) </span></label><br>

                        </li>
                        <input type="number" name="master_number" >
                            <li>
                                <input type="radio" id="other" name="method_payment" value="5">
                                <label for="other">{{ __('message.Cash on Delivery') }}<span>&nbsp; &nbsp; ( +5 EGP ) </span></label>

                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                               <h4 class="cart-bottom-title section-bg-gray">Use Promo Code</h4>
                            </div>
                            <div class="discount-code">
                                <p>Enter your Promo code if you have one.</p>
                                    <input type="text"  name="promoCodes_id">
                            </div>
                        </div>
                    </div>
                    <button class="cart-btn-2 w-100" type="submit">Proceed to Checkout</button>
                        {{-- <h4 class="grand-totall-title">Grand Total  <span>
                            @php
                                $method_payment=0.9;
                                $grand_total= $sum * $method_payment;
                                echo $grand_total . "EGP";
                            @endphp
                        </span>
                    </h4> --}}

            </form>
        </div>
    </div>
</div>
@endsection
