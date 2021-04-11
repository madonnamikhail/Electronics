@extends('layouts.site')
@section('title','Hot Deals')
@section('content')
<div class="col-12">
    <!-- New Products Start -->
<div class="product-area gray-bg pt-90 pb-65" style="margin: 20px;">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">Hot Deals</h3>
                {{-- <p>From 50% up to 80%</p> --}}
            </div>
        </div>
        <div class="row">

                @foreach($products_offers as $product_offer)
                <div class="col-3 ">
                    <div class="product-wrapper-single">
                    <div class="product-wrapper mb-30">
                        <div class="product-img">
                            {{-- <a href="product-details.html"> --}}
                            <a href="{{ route('get-product-single-page', $product_offer->id) }}">
                                <img alt="" src="{{ asset('images/product/'.$product_offer->photo) }}">
                            </a>
                            <span>{{$discount_value}}%</span>
                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.html">{{ $product_offer->name_en }}</a>
                                    </h4>
                                </div>
                                <div class="cart-hover">
                                    <h4><a href="product-details.html">+ Add to cart</a></h4>

                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <span>EGP {{ $product_offer->price *((100-trim($discount_value,"% , -"))/(100)) }} -</span>

                                <span class="product-price-old">EGP {{ $product_offer->price }} </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @endforeach



        </div>
    </div>
</div>
<!-- New Products End -->
</div>
@endsection
