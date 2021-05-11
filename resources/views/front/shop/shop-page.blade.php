@extends('layouts.site')
@section('title','Shop')

@section('content')
    <div class="col-lg-12">
        <!-- Breadcrumb Area Start -->
        {{-- <div class="breadcrumb-area bg-image-3 ptb-150"> --}}
            {{-- <div class="container"> --}}
                <div class="breadcrumb-content text-center">
                        <h3>SHOP PAGE</h3>
                        <ul>
                            <li ><a style="color:black" href="{{ route('index.page') }}">Home</a></li>
                            <li style="color:black" class="active">SHOP PAGE</li>
                        </ul>
                </div>
            {{-- </div> --}}
        {{-- </div> --}}
		<!-- Breadcrumb Area End -->
		<!-- Shop Page Area Start -->
        <div class="shop-page-area ptb-100">
            <div class="container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-9">
                        <div class="shop-topbar-wrapper">
                            <div class="shop-topbar-left">
                                <ul class="view-mode">
                                    <li class="active"><a href="#product-grid" data-view="product-grid"><i class="fa fa-th"></i></a></li>
                                    <li><a href="#product-list" data-view="product-list"><i class="fa fa-list-ul"></i></a></li>
                                </ul>
                                <p>Showing 1 - 20 of 30 results  </p>
                            </div>
                            {{-- <div class="product-sorting-wrapper">
                                <div class="product-shorting shorting-style">
                                    <label>View:</label>
                                    <select>
                                        <option value=""> 20</option>
                                        <option value=""> 23</option>
                                        <option value=""> 30</option>
                                    </select>
                                </div>
                                <div class="product-show shorting-style">
                                    <label>Sort by:</label>
                                    <select>
                                        <option value="">Default</option>
                                        <option value=""> Name</option>
                                        <option value=""> price</option>
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                        {{-- <div class="causes_div">

                        </div> --}}
                        <div class="grid-list-product-wrapper">
                            <div class="product-grid product-view pb-20">
                                <div class="row filter_data causes_div" id="products_container">
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

                                    @forelse ($products as $product)
                                        <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30 search-results-block" id="searchResults">
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    <a href="{{ route('get-product-single-page', $product->product_id) }}">
                                                        <img alt="" src="{{ asset('images\product\\'. $product->product_photo ) }}">
                                                    </a>
                                                    @if($product->discount )
                                                        <span style="background-color: #CCA43B;">{{$product->discount}}%</span>
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
                                                                </h4><a href="{{ route('get-product-single-page', $product->product_id) }}">{{ $product->name_en }}</a>
                                                            </h4>
                                                        </div>
                                                        <div class="cart-hover">
                                                            @auth
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
                                                <div class="product-list-details">
                                                    <h4>
                                                        <a href="#">{{ $product->name_en }}</a>
                                                    </h4>
                                                    <div class="product-price-wrapper">
                                                        @if($product->discount )
                                                            <span>EGP {{ $product->price_after_discount }} -</span>
                                                            <span class="product-price-old">EGP {{ $product->price}} </span>
                                                        @else
                                                            <span >EGP {{ $product->price}} </span>
                                                        @endif
                                                    </div>
                                                    <p>{{ $product->product_details_en }}</p>
                                                    <div class="shop-list-cart-wishlist">
                                                        <a href="#" title="Wishlist"><i class="ion-android-favorite-outline"></i></a>
                                                        <a href="#" title="Add To Cart"><i class="ion-ios-shuffle-strong"></i></a>
                                                        <a href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                                            <i class="ion-ios-search-strong"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $id = $product->product_id;
                                        @endphp
                                    @empty

                                    @endforelse
                                </div>
                            </div>

                            <div class="pagination-total-pages" id="remove_row">
                                {{-- <div class="total-pages">
                                    <p>Showing 1 - 20 of 30 results  </p>
                                </div> --}}
                                    <button class="alert alert-success ml-auto mr-auto w-100 h-100vh"
                                    style="outline: none; border:none" id="load_more"
                                    data-id="{{ $id }}" type="button">Load More</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                            <form action="{{ route('filter') }}" method="get" id="filter_form">
                                @csrf
                                <div class="shop-widget">
                                    <h4 class="shop-sidebar-title">Shop By Categories</h4>
                                    <div id="collapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                        <ul>
                                            @forelse ($categories as $category)
                                                        <li><input id="cat_{{$category->id}}" type="checkbox" {{(in_array($category->id,$cats)? 'checked':'')}}
                                                            attr-name="{{$category->name_en }}" name="cats[]" value="{{$category->id}}" class="filter_checkbox">
                                                            <label for="cat_{{$category->id}}">{{ucfirst($category->name_en)}}</label>

                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no categories to show</a>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">By Subcategory</h4>

                                    <div id="subcategorycollapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                        <ul>
                                            @forelse ($subCategories as $subCategory)
                                            <li><input id="sub_{{$subCategory->id}}" type="checkbox" {{(in_array($subCategory->id,$subs)? 'checked':'')}}
                                                attr-name="{{$subCategory->name_en }}" name="subs[]" value="{{$subCategory->id}}" class="filter_checkbox">
                                                <label for="sub_{{$subCategory->id}}">{{ucfirst($subCategory->name_en)}}</label>
                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no Subcategories to show</a>
                                            @endforelse

                                        </ul>
                                    </div>
                                </div>
                                <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">By Brand</h4>
                                    <div id="brandcollapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                        <ul>
                                            @forelse ($brands as $brand)
                                            <li><input id="brands_{{$brand->id}}" type="checkbox" {{(in_array($brand->id,$brand_ids)? 'checked':'')}}
                                                attr-name="{{$brand->name_en }}" name="brands[]" value="{{$brand->id}}" class="filter_checkbox">
                                                <label for="brands_{{$brand->id}}">{{ucfirst($brand->name_en)}}</label>
                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no Brands to show</a>
                                            @endforelse

                                        </ul>
                                    </div>
                                </div>
                                <h4 class="shop-sidebar-title">Price Filter</h4>
                                        <h3>Price</h3>
                                        {{-- <input type="hidden" id="hidden_minimum_price" class="filter_checkbox" name="min_price" value="{{ $min }}" />
                                        <input type="hidden" id="hidden_maximum_price" class="filter_checkbox" name="max_price" value="{{ $max }}" />
                                        <p id="price_show" class="filter_checkbox">{{ $min }} - {{ $max }}</p>
                                        <div class="filter_checkbox" id="price_range"></div> --}}

                                        {{-- <input type="hidden" id="hidden_minimum_price" value ="{{   $url !== NULL ?  $url->min_price  : '0' }}"/>
                                        <input type="hidden" id="hidden_maximum_price" value ="{{   $url !== NULL ?  $url->max_price  : '650000'}}"/>
                                        <p id="price_show" >{{   $url !== NULL ?  $url->min_price  : '0' }} - {{   $url !== NULL ?  $url->max_price  : '650000'}} </p>
                                        {{-- <div class="filter_checkbox" id="price_range"></div>
                                        <div class="price_slider" id="price_range"></div> --}}
                                        <input type="number" style="width:100px " {{--min=0 max="9900" oninput="validity.valid||(value='0');" --}} value ="{{   $url !== NULL ?  $url->min_price  : '0' }}" name="min_price" id="min_price" class="price-range-field" />
                                        <input type="number" style="width:100px " {{-- min=0 max="10000" oninput="validity.valid||(value='10000');" --}} value ="{{   $url !== NULL ?  $url->max_price  : '650000'}}" name="max_price" id="max_price" class="price-range-field" />
                                        <div id="slider-range" class="price-filter-range" name="rangeInput" style="width:210px; margin-top:20px" ></div>
                                        <button class="price-range-search filter_checkbox" id="price-range-submit">Search</button>

                            </form>
                            {{-- <div class="shop-price-filter mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">Price Filter</h4>
                                <div class="col-lg-12">
                                    <div class="list-group">
                                        <h3>Price</h3>
                                        <input type="hidden" id="hidden_minimum_price" value="0" />
                                        <input type="hidden" id="hidden_maximum_price" value="650000" />
                                        <p id="price_show">0 - 650000</p>
                                        <div id="price_range"></div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <br />
                                   <div class="row ">
                                    </div>
                                </div>
                                {{-- <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">By Brand</h4>

                                    <div class="card leftNav cate-sect mb-30">
                                        <p>Refine By:<span class="_t-item_brand">(0 items)</span></p>
                                        <div class="" id="brandFilters"></div>
                                    </div>
                                    <div id="brandcollapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                        <ul>
                                            @php
                                                $counterb =0;
                                            @endphp
                                            @forelse ($brands as $brand)
                                                <li><input id="{{$brand->id}}" type="checkbox" {{($counterb == 0 ? 'checked':'')}}
                                                    brand-attr-name="{{$brand->name_en }}" class="brand_checkbox">
                                                    <label for="{{$brand->id}}">{{ucfirst($brand->name_en)}}</label>
                                                @php
                                                    $counterb ++;
                                                @endphp
                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no cats</a>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div> --}}
                                {{-- <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">By Subcategory</h4>
                                    <div class="card leftNav cate-sect mb-30">
                                        <p>Refine By:<span class="_t-item_subcategory">(0 items)</span></p>
                                        <div class="" id="subcategoryFilters"></div>
                                    </div>
                                    <div id="subcategorycollapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                        <ul>
                                            @php
                                                $countersubcategory =0;
                                            @endphp
                                            @forelse ($subCategories as $subCategory)
                                                <li><input id="{{$subCategory->id}}" type="checkbox" {{($countersubcategory == 0 ? 'checked':'')}}
                                                    subcategory-attr-name="{{$subCategory->name_en }}" class="subcategory_checkbox">
                                                    <label for="{{$subCategory->id}}">{{ucfirst($subCategory->name_en)}}</label>
                                                @php
                                                    $countersubcategory ++;
                                                @endphp
                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no cats</a>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">Compare Products</h4>
                                    <div class="compare-product">
                                        <p>You have no item to compare. </p>
                                        <div class="compare-product-btn">
                                            <span>Clear all </span>
                                            <a href="#">Compare <i class="fa fa-check"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">Popular Tags</h4>
                                    <div class="shop-tags mt-25">
                                        <ul>
                                            <li><a href="#">Green</a></li>
                                            <li><a href="#">Oolong</a></li>
                                            <li><a href="#">Black</a></li>
                                            <li><a href="#">Pu'erh</a></li>
                                            <li><a href="#">Dark </a></li>
                                            <li><a href="#">Special</a></li>
                                        </ul>
                                    </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- Shop Page Area End -->
    </div>
@endsection
@section('script')
{{-- <script src="jslibs/jquery.js" type="text/javascript"></script>
<script src="jslibs/ajaxupload-min.js" type="text/javascript"></script> --}}

    {{-- <script>
        $(document).ready(function(){
            $(document).on('click','#load_more', function(event){
            // function loadingMore() {
               event.preventDefault();

                var id = $('#load_more').data('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                console.log(id);
                $.ajax({
                    url: '{{ route('load.more') }}',
                    type: 'post',
                    data: {
                    _token : token ,
                    id: id,
                    },
                    // dataType:"text",
                    success: function (response) {
                        if(response != ''){
                            console.log("mmmm");
                            $('#remove_row').remove();
                            $('#products_container').append(response);
                        }else{
                            $('#load_more').html("No Data");
                        }
                    },
                });
            // }

            });
        });
    </script> --}}
    {{-- loadmore --}}
    <script>
        $(document).ready(function(){
            $(document).on('click','#load_more', function(event){
            // function loadingMore() {
               event.preventDefault();

                var id = $('#load_more').data('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                console.log(id);
                $.ajax({
                    url: '{{ route('load.more') }}',
                    type: 'post',
                    data: {
                    _token : token ,
                    id: id,
                    },
                    // dataType:"text",
                    success: function (response) {
                        if(response != ''){
                            console.log("mmmm");
                            $('#remove_row').remove();
                            $('#products_container').append(response);
                        }else{
                            $('#load_more').html("No Data");
                        }
                    },
                });
            // }

            });
        });
    </script>
    {{-- category script --}}
    {{-- <script>
        $(document).ready(function() {
            $(document).on('click', '.category_checkbox', function () {
                var ids = [];
                var counter = 0;
                $('#catFilters').empty();
                $('.category_checkbox').each(function () {
                    if ($(this).is(":checked")) {
                        ids.push($(this).attr('id'));
                        $('#catFilters').
                        append(`<div class="alert fade show alert-color _add-secon"
                        role="alert"> ${$(this).attr('attr-name')}
                            <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close"><span aria-hidden="true">×</span>
                                </button> </div>`);
                        counter++;
                    }
                });

                $('._t-item').text('(' + ids.length + ' items)');

                // if (counter == 0) {
                //     $('.causes_div').empty();
                //     $('.causes_div').append('No Data Found');
                // } else {
                    fetchCauseAgainstCategory(ids);
                // }
            });
        });

        function fetchCauseAgainstCategory(id) {

            $('.causes_div').empty();

            $.ajax({
                type: 'GET',
                url: 'get_causes_against_category/' + id,
                success: function (response) {
                    var response = response;
                    // console.log("l response: ");
                    console.log(response);
                    var t = "looping";
                    $('.causes_div').append(response);
                    // $('.causes_div').append('lpllpllplplpl');

                    // if (response.length == 0) {
                    //     $('.causes_div').append('No Data Found');
                    // } else {
                    //     response.forEach(element => {
                    //         $('.causes_div').append(`<div href="#" class="col-lg-4 col-md-6 col-sm-6 col-xs-12 r_Causes IMGsize">

                    //                 <div class="img_thumb">
                    //                 <div class="h-causeIMG">
                    //                     <img src="${element.photo}" alt="" />
                    //                     </div>

                    //                 </div>
                    //                 <h3>${element.name_en}</h3>

                    //         </div>`);
                    //         $('.causes_div').append(response);
                    //     });
                    // }
                }
            });
        }
    </script> --}}
    {{-- brand script --}}
    {{-- <script>
        $(document).ready(function() {
            $(document).on('click', '.brand_checkbox', function () {
                var ids = [];
                var counter = 0;
                $('#brandFilters').empty();
                $('.brand_checkbox').each(function () {
                    if ($(this).is(":checked")) {
                        ids.push($(this).attr('id'));
                        $('#brandFilters').
                        append(`<div class="alert fade show alert-color _add-secon" role="alert"> ${$(this).attr('brand-attr-name')}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button> </div>`);
                        counter++;
                    }
                });

                $('._t-item_brand').text('(' + ids.length + ' items)');

                if (counter == 0) {
                    $('.causes_div').empty();
                    $('.causes_div').append('No Data Found');
                } else {
                    fetchCauseAgainstbrand(ids);
                }
            });
        });

        function fetchCauseAgainstbrand(id) {
            $('.causes_div').empty();
            $.ajax({
                type: 'GET',
                url: 'get-brand/' + id,
                success: function (response) {
                    var response = response;
                    console.log(response);
                    $('.causes_div').append(response);
                }
            });
        }
    </script> --}}
     {{-- subcategory script --}}
     {{-- <script>
        $(document).ready(function() {
            $(document).on('click', '.subcategory_checkbox', function () {
                var Subids = [];
                var countersubcategory = 0;
                $('#subcategoryFilters').empty();
                $('.subcategory_checkbox').each(function () {
                    if ($(this).is(":checked")) {
                        Subids.push($(this).attr('id'));
                        $('#subcategoryFilters').
                        append(`<div class="alert fade show alert-color _add-secon"
                         role="alert"> ${$(this).attr('subcategory-attr-name')}
                            <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close"><span aria-hidden="true">×</span>
                                </button> </div>`);
                        countersubcategory++;
                    }
                });

                $('._t-item_subcategory').text('(' + Subids.length + ' items)');

                // if (countersubcategory == 0) {
                //     $('.causes_div').empty();
                //     $('.causes_div').append('No Data Found');
                // } else {
                    fetchCauseAgainstSubcategory(Subids);
                // }
            });
        });

        function fetchCauseAgainstSubcategory(Subids) {
            $('.causes_div').empty();
            $.ajax({
                type: 'GET',
                url: 'get-subcategory/' + Subids,
                success: function (response) {
                    var response = response;
                    console.log(response);
                    $('.causes_div').append(response);
                }
            });
        }
    </script> --}}
    {{-- price filter script --}}
    {{-- <script>
        $(document).ready(function(){
        filter_data();
        function filter_data()
        {
            $('.filter_data').html('<div id="loading" style="" ></div>');
            var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:'{{route('price.filter')}}',
                type:"POST",
                data:{_token : token ,action:action, minimum_price:minimum_price, maximum_price:maximum_price},
                success:function(data){
                    $('.filter_data').html(data);
                    // console.log("huhuuh");
                    // console.log(data);
                }
            });
        }
        $('#price_range').slider({
            range:true,
            min:0,
            max:650000,
            values:[0, 650000],
            step:50,
            stop:function(event, ui)
            {
                $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                filter_data();
            }
        });
    });
    </script> --}}
    {{-- multiple filters --}}
    {{-- <p>ghjdjfc</p> --}}
    {{-- <script>
        $(document).ready(function() {
            // event.preventDefault();
            if(window.location.toString().indexOf("filter") > -1) // This doesn't work, any suggestions?
                {
                     $('#remove_row').remove();
                }
             var urlsearch = window.location.search;
            console.log(urlsearch);
            var urlParams = new URLSearchParams(urlsearch);
            var min_price = urlParams.get('min_price');
            console.log(min_price);
            var max_price = urlParams.get('max_price');
            console.log(max_price);
            // $('#price_show').html(min_price + ' -*-/ ' + max_price);
            //  document.getElementById('#price_show').innerHTML=min_price + ' - ' + max_price;
            // $('#hidden_minimum_price').val(min_price);
            // $('#hidden_maximum_price').val(max_price);

            $(document).on('click', '.filter_checkbox', function () {
                fetchCauseAgainstCategory();
            });
            $(document).on('click', '.price_slider', function () {
                document.getElementById('hidden_minimum_price').setAttribute("name", "min_price");
                document.getElementById('hidden_maximum_price').setAttribute("name", "max_price");
                fetchCauseAgainstCategory();
            });
        });
        function fetchCauseAgainstCategory() {
            $('.causes_div').empty();
            // console.log(window.location.href);
            // var url = window.location.href;
            $('#filter_form').submit();
        }
        $('#price_range').slider({
            range:true,
            min:0,
            max:650000,
            values:[0, 650000],
            step:50,
            stop:function(event, ui)
            {
                $('#price_show').html(ui.values[0] + ' -- ' + ui.values[1]);
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
            }
        });
        // $('#price_show').html($('#price_range').slider("values",0)+ "--" + $('#price_range').slider("values",1));
    </script> --}}
    <script>
         $(document).ready(function() {
            if(window.location.toString().indexOf("filter") > -1) // This doesn't work, any suggestions?
                {
                     $('#remove_row').remove();
                }
            $(document).on('click', '.filter_checkbox', function () {
                fetchCauseAgainstCategory();
            });
        });
        function fetchCauseAgainstCategory() {
            $('.causes_div').empty();
            // console.log(window.location.href);
            // var url = window.location.href;
            $('#filter_form').submit();
        }
        $("#slider-range").slider({
            range: true,
            orientation: "horizontal",
            min: 0,
            max: 10000,
            values: [@php  $url != NULL ?  $url->min_price  : '0' @endphp , @php $url != NULL ?  $url->max_price  : '650000' @endphp],
            step: 100,

            slide: function (event, ui) {
                if (ui.values[0] == ui.values[1]) {
                return false;
                }

                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);

            }
            $("#min_price").val($("#slider-range").slider("values", 0));
	        $("#max_price").val($("#slider-range").slider("values", 1));

            });

    </script>
@endsection
