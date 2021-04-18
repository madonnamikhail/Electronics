@extends('layouts.site')
@section('titile','Total')
@section('content')
<div class="col-12" style="margin:20px auto ; "> <div class="title-wrap">
                <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
            </div>
    <div class="col-lg-12 col-md-12">
        <div class="grand-totall" >


            <form method="post" action="{{ route('place.order') }}" enctype="multipart/form-data">
                @csrf
                {{-- 3ayzeno 3shan al address yfdal m3aya --}}
                <input type="hidden" name="address_id" value="{{ $address_id }}">
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
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $netPrice =0;

                        @endphp
                            @foreach ($products as $product)
                                @if ($product->user_id == $user_id)
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img style="width:80%" src="{{ asset('images\product\\'. $product->product_photo ) }}" alt=""></a>
                                    </td>
                                    <input type="hidden" name="photo[]" value="{{ $product->product_photo }}">
                                    <td class="product-name"><a href="#">{{ $product->name_en }} </a></td>
                                    <input type="hidden" name="name[]" value="{{ $product->name_en }}">
                                    <td class="product-price-cart"><span class="amount">
                                        @if ($product->discount)
                                            {{ $product->price_after_discount }}
                                            <input type="hidden" name="price[]" value="{{ $product->price_after_discount }}">
                                        @else
                                            {{ $product->price }}
                                            <input type="hidden" name="price[]" value="{{ $product->price }}">
                                        @endif
                                    </span></td>


                                    <td class="product-quantity">
                                        <div class="pro-dec-cart">
                                            <p class="cart-plus-minus-box">{{ $product->quantity }}</p>
                                            <input type="hidden" name="quantity[]" value="{{ $product->quantity }}">
                                        </div>
                                    </td>
                                    <td>
                                        @if ($product->discount)
                                            {{ $product->total_price_after_discount }}
                                            <input type="hidden" name="productPrice[]" value="{{ $product->total_price_after_discount }}">
                                        @else
                                            {{ $product->total_price }}
                                            <input type="hidden" name="productPrice[]" value="{{ $product->total_price }}">
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $netPrice += $product->total_price_after_discount;

                                @endphp
                                @endif
                            @endforeach
                        </tbody>
                </table>
            </div>
            <hr>
                    <h3><span style="font-weight:600">{{ __('message.Net Total Price') }}: </span>
                        <span style="float: right;">@php
                            echo $netPrice;
                         @endphp
                         EGP</span>
                    </h3>
                    <hr>
                    <section class="">
                        <h3 style="font-weight:600">Order will be deliverd to :</h3>
                        <p style="padding-left:50px"> <span style="font-weight:600"> Flat Number: </span> {{ $address->flat }} , <br>
                            <span style="font-weight:600"> Building number: </span> {{ $address->building }} , <br>
                            <span style="font-weight:600">  Floor Number: </span>{{ $address->floor }}, <br>
                            <span style="font-weight:600">  Street Name: </span> {{ $address->street_en }} , <br>
                            @foreach ($regions as $region)
                                @if($region->id == $address->region_id)
                                <span style="font-weight:600"> Region: </span>{{ $region->name_en }}, <br>
                                    @php
                                        $region_city_id = $region->city_id;
                                    @endphp
                                @endif
                            @endforeach

                                @foreach ($cities as $city)
                                    @if($city->id == $region_city_id)
                                    <span style="font-weight:600"> City: </span>{{ $city->name_en }}
                                    @endif
                                @endforeach
                        </p>

                    </section>
                    <hr>
                    <div class="total-shipping">
                        <h3 style="font-weight:600">{{ __('message.Payment Method') }}</h3>
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
