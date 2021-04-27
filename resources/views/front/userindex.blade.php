@extends('layouts.site')
@section('title','Index')
@section('css')
<style>

.btn-grad {background-image: linear-gradient(to right, #3CA55C 0%, #B5AC49  51%, #3CA55C  100%)}
         .btn-grad {
            margin: 50px 5px 50px 5px;
            padding: 15px 40px;
            text-align: center;
            text-transform: uppercase;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 0 20px #eee;
            border-radius: 10px;
            display: block;
          }

          .btn-grad:hover {
            background-position: right center; /* change the direction of the change here */
            color: #fff;
            text-decoration: none;
          }

</style>
@endsection
@section('content')
{{-- <div class="slider-area">
    <div class="slider-active owl-dot-style owl-carousel">
        <div class="single-slider ptb-240 bg-img" style="background-image:url({{ asset('assets/img/slider/slider-1.jpg') }});">
            <div class="container">
                <div class="slider-content slider-animated-1">
                    <h1 class="animated">Want to stay <span class="theme-color">healthy</span></h1>
                    <h1 class="animated">drink matcha.</h1>
                    <p>Lorem ipsum dolor sit amet, consectetu adipisicing elit sedeiu tempor inci ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="single-slider ptb-240 bg-img" style="background-image:url({{ asset('assets/img/slider/slider-1-1.jpg') }});">
            <div class="container">
                <div class="slider-content slider-animated-1">
                    <h1 class="animated">Want to stay <span class="theme-color">healthy</span></h1>
                    <h1 class="animated">drink matcha.</h1>
                    <p>Lorem ipsum dolor sit amet, consectetu adipisicing elit sedeiu tempor inci ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- Slider End -->
{{-- <!-- shop by brand buttons -->
<h3 style="margin:50px; ">Shop By Brand </h3> --}}
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="section-title-wrap text-center">
                <h3 class="section-title" style="margin-top:50px">shop by brand</h3>
            </div>
            <div class="featured-product-active hot-flower owl-carousel product-nav">
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>
                <button class="btn-grad"> Apple </button>

            </div>

        </div>
    </div>

</div>



<!--  Hot Deals Banner Start -->
<div class="banner-area pt-100 pb-70">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">Hot Deals</h3>
            </div>
        </div>
        <div class="banner-wrap">
            <div class="row" >
                @foreach ($offers as $offer)
                    @if ($offer->discount == 50 || $offer->discount > 50)
                        <div class="col-lg-6 col-md-6">
                            <div class="single-banner img-zoom mb-30">
                                <a href="{{ route('hot.deals',$offer->id) }}">
                                    <img style="width:30vw; height:40vh" src="{{ asset('images/offers/'.$offer->photo ) }}" alt="">
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Hot Deals Banner End -->
<!--  all sales Banner Start -->

<div class="banner-area pt-100 pb-70">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">Sale</h3>
            </div>
        </div>
        <div class="banner-wrap">
            <div class="row" style="display:flex">
                @foreach ($offers as $offer)
                    @if ($offer->discount < 50)
                        <div class="col-lg-4 col-md-4">
                            <div class="single-banner img-zoom mb-30">
                                <a href="{{ route('hot.deals',$offer->id) }}">
                                    <img style="width:50%;"src="{{ asset('images/offers/'.$offer->photo ) }}" alt="">
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- all sales Banner End -->
<!-- Product Area Start (doneeeeeeeeeeeeeeeeeeeeee)-->
<div class="product-area bg-image-1 pt-100 pb-95">
    <div class="container">
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
        <div class="featured-product-active hot-flower owl-carousel product-nav">
            @foreach($products as $product)
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="{{ route('get-product-single-page',$product->products_id) }}">
                        <img alt="" src="{{ asset('images\product\\'.$product->product_photo ) }}">
                    </a>
                        @if($product->discount )
                            <span>{{$product->discount}}%</span>
                        @endif
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
                                <a href="#">{{ $product->name_en }}</a>
                            </h4>
                        </div>
                        <div class="cart-hover">
                            {{-- <h4><a href="product-details.html">+ Add to cart</a></h4> --}}
                            @auth('web')
                                <form action="{{ route('add.to.cart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="product_id" value="{{ $product->products_id }}">
                                    <button type="submit">
                                        <a class="action-cart" title="Add To Cart">
                                            + Add to cart
                                            <i class="ion-ios-shuffle-strong"></i>
                                        </a>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                    <div class="product-price-wrapper">
                        @if($product->discount )
                                <span>EGP {{ $product->price_after_discount }} -</span>
                                <span class="product-price-old">EGP {{ $product->price}} </span>
                        @else
                            <span >EGP {{ $product->price}} </span>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('get.shop') }}">Load More</a>
</div>
<!-- Product Area End -->
<!-- Banner Start -->
<div class="banner-area pt-100 pb-70">
    <div class="container">
        <div class="banner-wrap">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single-banner img-zoom mb-30">
                        <a href="#">
                            <img src="{{ asset('assets/img/banner/banner-1.png') }}" alt="">
                        </a>
                        <div class="banner-content">
                            <h4>-50% Sale</h4>
                            <h5>Summer Vacation</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="single-banner img-zoom mb-30">
                        <a href="#">
                            <img src="{{ asset('assets/img/banner/banner-2.png') }}" alt="">
                        </a>
                        <div class="banner-content">
                            <h4>-20% Sale</h4>
                            <h5>Winter Vacation</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->
<!-- New Products Start -->
<div class="product-area gray-bg pt-90 pb-65">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">New Products</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($newest_products as $newest_product)
            {{-- <h1> {{ $newest_product->price }}</h1> --}}
            <div class="col-3 d-flex">
                <div class="product-wrapper-single">
                                <div class="product-wrapper mb-30">
                                    <div class="product-img">
                                        <a href="{{ route('get-product-single-page', $product->products_id) }}">
                                            <img alt="" src="{{ asset('images/product/'.$newest_product->photo) }}">
                                        </a>
                                        @foreach ($newest_product->offers as $offer)
                                            @if($offer->discount)
                                                <span>{{ $offer->discount }}%</span>
                                            @endif
                                        @endforeach
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
                                                    <a href="{{ route('get-product-single-page', $product->products_id) }}">{{ $newest_product->name_en }}</a>
                                                </h4>
                                            </div>
                                            <div class="cart-hover">
                                                <h4><a href="product-details.html">+ Add to cart</a></h4>
                                            </div>
                                        </div>

                                        <div class="product-price-wrapper">
                                                @if(count($newest_product->offers)>0)
                                                    @foreach ($newest_product->offers as $offer)
                                                    <span>EGP {{ $newest_product->price*((100-$offer->discount)/100) }}-</span>
                                                    <span class="product-price-old">EGP{{ $newest_product->price }}</span>
                                                    @endforeach
                                                @else
                                                     <span >EGP{{ $newest_product->price }}</span>
                                                @endif

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
<!-- Testimonial Area Start -->
<div class="testimonials-area bg-img pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="testimonial-active owl-carousel">
                    <div class="single-testimonial text-center">
                        <div class="testimonial-img">
                            <img alt="" src="{{ asset('assets/img/icon-img/testi.png') }}">
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore</p>
                        <h4>Gregory Perkins</h4>
                        <h5>Customer</h5>
                    </div>
                    <div class="single-testimonial text-center">
                        <div class="testimonial-img">
                            <img alt="" src="{{ asset('assets/img/icon-img/testi.png') }}">
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore</p>
                        <h4>Khabuli Teop</h4>
                        <h5>Marketing</h5>
                    </div>
                    <div class="single-testimonial text-center">
                        <div class="testimonial-img">
                            <img alt="" src="{{ asset('assets/img/icon-img/testi.png') }}">
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore </p>
                        <h4>Lotan Jopon</h4>
                        <h5>Admin</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial Area End -->
<!-- News Area Start -->
<div class="blog-area bg-image-1 pt-90 pb-70">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">Latest News</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="blog-single mb-30">
                    <div class="blog-thumb">
                        <a href="#"><img src="{{ asset('assets/img/blog/blog-single-1.jpg') }}" alt="" /></a>
                    </div>
                    <div class="blog-content pt-25">
                        <span class="blog-date">14 Sep</span>
                        <h3><a href="#">Lorem ipsum sit ame co.</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eius tempor incididunt ut labore et dolore</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="blog-single mb-30">
                    <div class="blog-thumb">
                        <a href="#"><img src="{{ asset('assets/img/blog/blog-single-2.jpg') }}" alt="" /></a>
                    </div>
                    <div class="blog-content pt-25">
                        <span class="blog-date">20 Dec</span>
                        <h3><a href="#">Lorem ipsum sit ame co.</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eius tempor incididunt ut labore et dolore</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="blog-single mb-30">
                    <div class="blog-thumb">
                        <a href="#"><img src="{{ asset('assets/img/blog/blog-single-3.jpg') }}" alt="" /></a>
                    </div>
                    <div class="blog-content pt-25">
                        <span class="blog-date">18 Aug</span>
                        <h3><a href="#">Lorem ipsum sit ame co.</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eius tempor incididunt ut labore et dolore</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- News Area End -->
<!-- Newsletter Araea Start -->
<div class="newsletter-area bg-image-2 pt-90 pb-100">
    <div class="container">
        <div class="product-top-bar section-border mb-45">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">Join to our Newsletter</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 col-md-10 col-md-auto">
                <div class="footer-newsletter">
                     <div id="mc_embed_signup" class="subscribe-form">
                        <form action="http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div id="mc_embed_signup_scroll" class="mc-form">
                                <input type="email" value="" name="EMAIL" class="email" placeholder="Your Email Address*" required>
                                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                <div class="mc-news" aria-hidden="true"><input type="text" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" tabindex="-1" value=""></div>
                                <div class="submit-button">
                                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
