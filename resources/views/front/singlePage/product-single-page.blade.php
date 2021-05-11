@extends('layouts.site')
@section('title','product single page')
@section('css')
<style>
            *{
            margin: 0;
            padding: 0;
        }
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }

</style>

@endsection
@section('content')
    <div class="col-lg-12">

        <!-- Breadcrumb Area Start -->
        {{-- <div class="breadcrumb-area bg-image-3 ptb-150"> --}}
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>SINGLE PRODUCT</h3>
                    <ul>
                        <li><a style="color: black;" href="{{ route('index.page') }}">Home</a></li>
                        <li style="color: black;" class="active">Single Product</li>
                    </ul>
                </div>
            </div>
        {{-- </div> --}}
		<!-- Breadcrumb Area End -->
		<!-- Product Deatils Area Start -->
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
        <div class="product-details pt-100 pb-95">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="product-details-img">
                            <img class="zoompro" src="{{ asset('images\product\\'. $product->product_photo ) }}" data-zoom-image="assets/img/product-details/product-detalis-bl1.jpg" alt="zoom"/>
                            @if($product->discount )
                                <span>{{$product->discount}}%</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="product-details-content">
                            <h4>{{ $product->name_en }}</h4>
                            <div class="rating-review">
                                <div class="pro-dec-rating">
                                    @for($i=0;$i<$product->rating_average;$i++)
                                        <i class="ion-android-star-outline theme-star"></i>
                                    @endfor
                                    @for($i=0;$i<5-($product->rating_average);$i++)
                                        <i class="ion-android-star-outline"></i>
                                    @endfor
                                </div>
                                <div class="pro-dec-review">
                                    <ul>
                                        <li>{{ $product->user_rating_count }} Reviews </li>
                                        {{-- <li><a>Add Your Reviews</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            @if($product->discount )
                                <span>EGP {{ $product->price_after_discount }} </span>
                                <span class="product-price-old" style="text-decoration: line-through">- EGP {{ $product->price}} </span>
                            @else
                                <span >EGP {{ $product->price}} </span>
                            @endif
                            <div class="in-stock">
                                @if ($product->status == 1)
                                    <p>Available: <span>In stock</span></p>
                                @else
                                    <p>Not available: <span style="color: red">Out of stock</span></p>
                                @endif

                            </div>
                            <p>{{ $product->product_details_en }}</p>
                            <div class="pro-dec-feature">
                                <ul>
                                    @forelse ($specs->specs as $spec)
                                        <li><span style="font-weight: 600">{{ $spec->name }}: </span> {{ $spec->pivot->value }}</li>
                                        {{-- <li> Protection Plan: <span> 2 year  $4.99</span></li> --}}
                                    @empty
                                        <p class="alert alert-danger">There are no specs for this prduct.</p>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="quality-add-to-cart">
                                @auth
                                    @if ($product->status == 1)
                                    <form action="{{ route('single.page.add.to.cart') }}" method="post">
                                        @csrf
                                            <div class="quality">
                                                <label>Qty:</label>
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="product_id" value="{{ $product->products_id }}">
                                                <input class="cart-plus-minus-box" type="text" name="quantity" value="1">
                                            </div>
                                            <div class="shop-list-cart-wishlist">
                                                <button type="submit" title="Add To Cart">Add To Cart
                                                    <i class="icon-handbag"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                @endauth

                            </div>
                            <div class="pro-dec-categories">
                                <ul>
                                    <li class="categories-title">Tags: </li>
                                    <li><a href="{{ route('get.products.by.category.id',$product->product_category_id) }}"> {{ $product->product_category }}, </a></li>
                                    <li><a href="{{ route('get.products.by.subcategory.id',$product->product_subcategory_id) }}"> {{ $product->product_subcategory }},</a></li>
                                    <li><a href="{{ route('get.products.by.brand.id',$product->product_brand_id) }}"> {{ $product->product_brand }}</a></li>
                                </ul>
                                <ul>
                                    <li class="categories-title" ><span style="text-decoration: underline">Supplier Name: </span>{{ $product->supplier_name }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- Product Deatils Area End -->
        <div class="description-review-area pb-70">
            <div class="container">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav text-center">
                        <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                        <a data-toggle="tab" href="#des-details2">Tags</a>
                        <a data-toggle="tab" href="#des-details3">Review</a>
                        <a data-toggle="tab" href="#des-details4">Specs</a>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="des-details1" class="tab-pane active">
                            <div class="product-description-wrapper">
                                <p>{{ $product->product_details_en }}</p>
                            </div>
                        </div>
                        <div id="des-details2" class="tab-pane">
                            <div class="product-anotherinfo-wrapper">
                                <ul>
                                    <li class="categories-title">Tags: </li>
                                    <li><a href="{{ route('get.products.by.category.id',$product->product_category_id) }}"> {{ $product->product_category }}, </a></li>
                                    <li><a href="{{ route('get.products.by.subcategory.id',$product->product_subcategory_id) }}"> {{ $product->product_subcategory }},</a></li>
                                    <li><a href="{{ route('get.products.by.brand.id',$product->product_brand_id) }}"> {{ $product->product_brand }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="des-details3" class="tab-pane">
                            <div class="rattings-wrapper">
                                @forelse ($ratings as $rating)
                                    <div class="sin-rattings">
                                        <div class="star-author-all">
                                            <div class="ratting-star f-left">
                                                @for($i=0;$i<$rating->pivot->value;$i++)
                                                    <i class="ion-star theme-color"></i>
                                                @endfor
                                                @for($i=0;$i<5-($rating->pivot->value);$i++)
                                                    <i class="ion-android-star-outline"></i>
                                                @endfor
                                                <span>({{ $rating->pivot->value }})</span>
                                            </div>
                                            <div class="ratting-author f-right">
                                                <h3>{{ $rating->name }}</h3>
                                                <span>12:24</span>
                                                <span>{{ $rating->pivot->updated_at }}</span>
                                            </div>
                                        </div>
                                        <p>{{ $rating->pivot->comment }}</p>
                                    </div>
                                @empty
                                    <p>No Reviews yet</p>
                                @endforelse

                            </div>
                            @auth
                            @forelse ($orders as $order)
                                @if ($order->status==2)
                                    @forelse ($order->products as $productt)
                                        @if ($productt->id == $product->products_id)
                                            <div class="ratting-form-wrapper">
                                                <form method="post" action="{{ route('insert') }}" name="rating">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->products_id }}">
                                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                <h3>Add your Comments :</h3>
                                                    <textarea row="2" col="4" name="comment" placeholder="Enter your comment"></textarea>
                                                <div class="ratting-form">
                                                    <form action="#">
                                                        <div class="star-box"><br>
                                                            <h3>Rating:</h3>
                                                            <div class="rate">
                                                                <input type="radio" id="star5_{{ $product->id }}" name="value" value="5" />
                                                                <label for="star5_{{ $product->id }}" title="text">5 stars</label>
                                                                <input type="radio" id="star4_{{ $product->id }}" name="value" value="4" />
                                                                <label for="star4_{{ $product->id }}" title="text">4 stars</label>
                                                                <input type="radio" id="star3_{{ $product->id }}" name="value" value="3" />
                                                                <label for="star3_{{ $product->id }}" title="text">3 stars</label>
                                                                <input type="radio" id="star2_{{ $product->id }}" name="value" value="2" />
                                                                <label for="star2_{{ $product->id }}" title="text">2 stars</label>
                                                                <input type="radio" id="star1_{{ $product->id }}" name="value" value="1" />
                                                                <label for="star1_{{ $product->id }}" title="text">1 star</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            {{-- <div class="col-md-6">
                                                                <div class="rating-form-style mb-20">
                                                                    <input placeholder="Name" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="rating-form-style mb-20">
                                                                    <input placeholder="Email" type="text">
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-md-12">
                                                                <div class="rating-form-style form-submit"><br><br><br>
                                                                    {{-- <textarea name="message" placeholder="Message"></textarea> --}}
                                                                    <button type="submit" value="add review">Add Review</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    @empty

                                    @endforelse
                                {{-- @else --}}
                                    {{-- <p style="color :red">Your order hasnot been derliverd yet ! </p> --}}
                                @endif
                            @empty
                                {{-- <p style="color :red">No orders have been placed yet ! </p> --}}
                            @endforelse


                            @endauth

                        </div>
                        <div id="des-details4" class="tab-pane">
                            <div class="product-description-wrapper">
                                @forelse ($specs->specs as $spec)
                                    <p><span style="font-weight: 600">{{ $spec->name }}: </span> {{ $spec->pivot->value }}</p>
                                @empty
                                     <p class="alert alert-danger">There are no specs for this prduct.</p>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-area pb-100">
            <div class="container">
                <div class="product-top-bar section-border mb-35">
                    <div class="section-title-wrap">
                        <h3 class="section-title section-bg-white">Related Products</h3>
                    </div>
                </div>
                <div class="row">
            @forelse ($supplier_product as $product)
                            <div class="col-lg-4 d-flex">
                                <div class="product-wrapper-single ">
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="{{ route('get-product-single-page', $product->products_id) }}">
                                            <img alt="" src="{{ asset('images/product/'.$product->product_photo) }}">
                                        </a>
                                        @if($product->offer_discount)
                                            <span>{{$product->offer_discount }}%</span>
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
                                                    <a href="{{ route('get-product-single-page', $product->products_id) }}">{{ $product->name_en }}</a>
                                                </h4>
                                            </div>
                                            <div class="cart-hover">
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
                                            @if($product->offer_discount)
                                            <span>EGP {{ $product->price*((100-$product->offer_discount)/100) }}-</span>
                                            <span class="product-price-old">EGP{{ $product->price }}</span>

                                        @else
                                            <span >EGP{{ $product->price }}</span>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty

                            @endforelse
                </div>

 </div>

            </div>
        </div>
    </div>
@endsection
