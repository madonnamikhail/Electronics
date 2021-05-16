@extends('layouts.site')
@section('title','Index')
@section('css')
<style>

.btn-grad {
    background-color: #CCA43B;
    }
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
        .sechover{
            background:#E5E5E5;
            text-align:center;
            width:160px;
            margin:20px;
            line-height:50px;
            border-radius: 10px;

        }
        .sechover:hover{
            border-radius: 30px;
            background:#CCA43B;
            color:white;
        }

    .salebtn{
        border-radius:10px;
        width:150px;
        height:100px;
        border:#CCA43B 5px solid;
        margin: 30px;
        background-color:white;
    }
    .salebtn:hover {
        border-radius:50px;
        width:150px;
        height:100px;
        border:#242F40 5px solid;
        background-color:rgba(204,164,59,1);
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
<div style="width:100%; height:20px; background-color:#CCA43B"> </div>

<div class="container">
    <div class="row">
       <div class="col-12">
            <section style="width: 100%; height: 300px; text-align: center; margin: 10px auto; padding: 58px 0 0 0;">
                <h1 style="margin-bottom: 30px">{{ __('message.SLOGAN') }}</h1>
                <p style="margin-bottom: 20px">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias optio consequuntur est vero doloribus exercitationem ducimus eveniet fugiat eos in, voluptas quam unde animi quisquam? Labore, odio. Dolores minima id quidem minus nam voluptatum dignissimos rem dolor amet recusandae! In!</p>
                <button style="background-color:#cca43b; border-radius:20px; padding:10px; width:200px;"><a style="margin: 0 auto; color:#242F40; font-size: 25px" href="{{ route("get.shop") }}">{{ __('message.Shop Now') }}</a>
</button>
            </section>
        </div>
    </div>
</div>
<div style="width:100%; height:10px; background-color:#242F40"> </div>

<!--  Hot Deals Banner Start -->
<div class="banner-area pt-50 pb-50">
    <div class="container">
        <div class="product-top-bar section-border mb-30">
            <div class="section-title-wrap text-center">
                <h2 class="section-title">{{__('message.Hot Deals')}}</h2>
            </div>
        </div>
        <div class="banner-wrap">
            <div class="row " >
                <div class="col-lg-12 ">
                     <div class="single-banner img-zoom mb-30 d-flex justify-content-center flex-nowrap">
                @foreach ($offers as $offer)
                    @if ($offer->discount == 50 || $offer->discount > 50)
                                {{-- <a href="{{ route('hot.deals',$offer->id) }}"> --}}
                                    <button class="salebtn"><a style="font-weight:600; color:black;" href="{{ route('hot.deals',$offer->id) }}">  {{ $offer->title_en }}</a></button>
                                    {{-- <img style="width:30vw; height:40vh" src="{{ asset('images/offers/'.$offer->photo ) }}" alt=""> --}}
                    @endif
                @endforeach
                </div>

             </div>
            </div>
        </div>
    </div>
</div>
<!-- Hot Deals Banner End -->
<!--  all sales Banner Start -->
<div style="width:100%; height:20px; background-color:#CCA43B"> </div>
<div class="banner-area pt-30 pb-30" style="width:100%; background-color:#242F40;">
    <div class="container">
        <div class="product-top-bar section-border mb-30">
            <div class="section-title-wrap text-center">
                <h1 class="section-title" style="color: #CCA43B ;">{{__('message.Sale')}}</h1>
            </div>
        </div>
        <div class="banner-wrap">
            <div class="row">
                <div class="col-lg-12 col-md-4">
                            <div class="single-banner img-zoom mb-30 d-flex justify-content-around flex-wrap">
                @foreach ($offers as $offer)
                    @if ($offer->discount < 50)

                                {{-- <a href="{{ route('hot.deals',$offer->id) }}">
                                    <img style="width:50%;"src="{{ asset('images/offers/'.$offer->photo ) }}" alt="">
                                </a> --}}
                                <button class="salebtn"><a style="font-weight:500; color:black;" href="{{ route('hot.deals',$offer->id) }}">  {{ $offer->title_en }}</a></button>


                    @endif
                @endforeach
             </div>
                        </div>
            </div>
        </div>
    </div>
</div>
<div style="width:100%; height:20px; background-color:#CCA43B"> </div>

<!-- all sales Banner End -->

<!-- Product Area Start (doneeeeeeeeeeeeeeeeeeeeee)-->
<div class="product-area bg-image-1 pt-40 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title-wrap text-center">
                    <h3 class="section-title" style=" margin-bottom:100px;">{{__('message.Popular Products')}}</h3>
                </div>
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
                                            <span style="background-color:#CCA43B;">{{$product->discount}}%</span>
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
                                                    <button type="submit" >
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
        </div>

    </div>
    <button style="margin-left:auto;margin-right:auto;"class="btn-grad"><a style="color: white;" href="{{ route('get.shop') }}">{{ __('message.Shop Now') }}</a></button>


</div>
<!-- Product Area End -->
<div style="width:100%; height:20px; background-color:#CCA43B"> </div>

<section style="width:100%;height:500px; background-color:rgba(36,47,64,1); text-align:center; padding:50px;">
    <h1 style="color:white; margin-bottom:60px;">{{__('message.Shop By Brand')}}<h1>
        @foreach ($brands as $brand)
        <button class="sechover" style="padding: 0 0 10px;"><a href="{{ route('get.products.by.brand.id',$brand->id) }}" style="font-size:20px;">{{ $brand->name_en }}</a></button>
        {{-- <button style="margin:5px; width:50px; "><a href="{{ route('get.products.by.brand.id',$brand->id) }}">{{ $brand->name_en }}</a></button> --}}
        @endforeach
</section>
<!-- Banner End -->
<!-- New Products Start -->
{{-- <div class="product-area gray-bg pt-10 pb-15">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h3 class="section-title">New Products</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($newest_products as $newest_product)
            <div class="col-3 d-flex">
                <div class="product-wrapper-single">
                                <div class="product-wrapper mb-10">
                                    <div class="product-img">
                                        <a href="{{ route('get-product-single-page', $product->products_id) }}">
                                            <img style="width:100%;"alt="" src="{{ asset('images/product/'.$newest_product->photo) }}">
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
</div> --}}
<div style="width:100%; height:20px; background-color:#CCA43B"> </div>
<div class="product-area gray-bg pt-10 pb-15">
    <div class="container">
        <div class="product-top-bar section-border mb-55">
            <div class="section-title-wrap text-center">
                <h1  style="padding:20px;">New Products</h1>
            </div>
        </div>
        <div class="row" style="padding-bottom:60px ">
            @foreach ($newest_products as $newest_product)
            <div class="col-3 d-flex">
                <div class="product-wrapper-single">
                                <div class="product-wrapper mb-10">
                                    <div class="product-img">
                                        <a href="{{ route('get-product-single-page', $product->products_id) }}">
                                            <img style="width:100%;"alt="" src="{{ asset('images/product/'.$newest_product->photo) }}">
                                        </a>
                                        @foreach ($newest_product->offers as $offer)
                                            @if($offer->discount)
                                                <span style="background-color:#CCA43B; ">{{ $offer->discount }}%</span>
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
<div style="width:100%; height:20px; background-color:#CCA43B"> </div>
<!-- New Products End -->
<section style="width:100%;height:400px;background-color:#363636; text-align:center;">
<h1 style="color:white; padding:30px;">Contact Us</h1>
<p style="color:#CCA43B; padding:30px;">You Can contact us or to send us any requests or complaints
<br>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore
    Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore</p>
    <button style="padding: 10px"><a style="margin: 0 auto; color:#cca43b; font-size: 25px" href="{{ route("get.shop") }}">{{ __('message.Contact Us') }}</a>
    </button>

</section>
<div style="width:100%; height:20px; background-color:#CCA43B"> </div>
<!-- Testimonial Area Start -->
<div class="testimonials-area bg-img pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="testimonial-active owl-carousel">
                    <div class="single-testimonial text-center">
                        <div class="testimonial-img">
                            <img alt="" src="{{ asset('assets/img/icon-img/testi.png') }}">
                            {{-- <p> <i style="color:#CCA43B;" class="fas fa-shopping-bag"></i></p> --}}

                            </div>
                        <h3>We All Adore A Shopping</h3>
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
{{-- <div class="blog-area bg-image-1 pt-90 pb-70">
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
</div> --}}
<!-- News Area End -->
<section style="width: 100%; height:500px; background-color:#CCA43B; text-align:center;padding:30px">
    <h1 style="color: black;">Shop By Category</h1>
    <div class="d-flex justify-content-around" style="padding:50px">
    @foreach ($categories as $category)
            <div>
                <h3>{{ $category->name_en }}</h3>
                <br>
                <img style="width:200px; height:150px" src="{{ asset('images/photo/'.$category->photo ) }}" alt="{{ $category->name_en }}">

            </div>

    @endforeach
</div>

</section>
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
