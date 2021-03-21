@extends('layouts.site')
@section('titile','Total')
@section('content')
<div class="col-12" style="margin:20px auto ; ">
    <div class="col-lg-12 col-md-12">
        <div class="grand-totall" >
            <div class="title-wrap">
                <h4 class="cart-bottom-title section-bg-gary-cart">Order Placed</h4>
            </div>
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
                            @foreach ($products as $product)
                                @if ($product->user_id == $user_id)
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img style="width:20%" src="{{ asset('images\product\\'. $product->product_photo ) }}" alt=""></a>
                                    </td>
                                    <td class="product-name"><a href="#">{{ $product->name_en }} </a></td>

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
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <section class="">
                        <h3>Order will be deliverd to :</h3>
                        <p><span style="font-weight:800">Flat number: </span> {{ $address->flat }} , <span style="font-weight:800"> Building number:</span>{{ $address->building }} ,
                            <span  style="font-weight:800"> Floor Number: </span>{{ $address->floor }} , <span style="font-weight:800">Street Name: </span> {{ $address->street_en }} ,
                            @foreach ($regions as $region)
                                @if($region->id == $address->region_id)
                                  <span style="font-weight:800">Region:</span>   {{ $region->name_en }}
                                    @php
                                        $region_city_id = $region->city_id;
                                    @endphp
                                @endif
                            @endforeach
                        ,
                                @foreach ($cities as $city)
                                    @if($city->id == $region_city_id)
                                    <span style="font-weight:800">  City:</span>  {{ $city->name_en }}
                                    @endif
                                @endforeach
                        </p>

                    </section>
                    <h5>{{ __('message.Net Total Price') }} <span>
                        {{-- @php
                           $sum= array_sum($productPrice);
                           echo $sum;
                        @endphp --}}
                        EGP
                    </span></h5>
                    <div class="total-shipping">
                        <h4>{{ __('message.Payment Method') }}</h5>
                        <h5>{{ $paymentMethod }} </h5>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                               <h4 class="cart-bottom-title section-bg-gray">Promo Code :
                                @if ($promoCode and $usage)
                                    {{ $promoCode->name }}

                                    @if($usage != 1)
                                        <div class="alert alert-danger">
                                            {{ $usage }}
                                        </div>
                                    @elseif($rangValue != 1 and $out_of_date != 1)
                                        <div class="alert alert-danger">
                                            {{ $rangValue }} and {{ $out_of_date }}
                                        </div>
                                    @elseif($rangValue != 1)
                                        <div class="alert alert-danger">
                                            {{ $rangValue }}
                                        </div>
                                    @elseif($out_of_date != 1)
                                        <div class="alert alert-danger">
                                            {{ $out_of_date }}
                                        </div>

                                    @endif
                                @else
                                    No Promo Code Entered !
                                @endif


                            </h4>
                            </div>
                        </div>
                    </div>
                        <h4 class="grand-totall-title">Grand Total  <span>
                            @if($promocode_type)
                                {{ "type:percentage" }}
                            @else
                                {{ "type:fixed" }}
                            @endif
                            {{-- @php
                                if($discountOfPromocode != 1){
                                    if($paymentMethod == "Master Card ( 10% Discount )")
                                        $grand_total= $sum * (0.9) * $discountOfPromocode;

                                    elseif ($paymentMethod == "Cash On Delivery ( +5 EGP )")
                                        $grand_total= ($sum + (5)) * $discountOfPromocode;
                                    echo $grand_total . "EGP";
                                }else{
                                    if($paymentMethod == "Master Card ( 10% Discount )")
                                        $grand_total= $sum * (0.9);

                                    elseif ($paymentMethod == "Cash On Delivery ( +5 EGP )")
                                        $grand_total= $sum + (5);
                                    echo $grand_total . "EGP";
                                }
                            @endphp --}}
                        </span>
                    </h4>
        </div>
    </div>
</div>
@endsection
