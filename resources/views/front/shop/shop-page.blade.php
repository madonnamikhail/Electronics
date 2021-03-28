@extends('layouts.site')
@section('title','Shop')
@section('content')
    <div class="col-lg-12">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-image-3 ptb-150">
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>SHOP PAGE</h3>
                    <ul>
                        <li><a href="{{ route('index.page') }}">Home</a></li>
                        <li class="active">SHOP PAGE</li>
                    </ul>
                </div>
            </div>
        </div>
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
                                        <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    <a href="{{ route('get-product-single-page', $product->product_id) }}">
                                                        <img alt="" src="{{ asset('images\product\\'. $product->product_photo ) }}">
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
                                                                </h4><a href="{{ route('get-product-single-page', $product->product_id) }}">{{ $product->name_en }}</a>
                                                            </h4>
                                                        </div>
                                                        <div class="cart-hover">
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
                            {{-- <div class="causes_div">

                            </div> --}}
                            <div class="pagination-total-pages" id="remove_row">
                                {{-- <div class="total-pages">
                                    <p>Showing 1 - 20 of 30 results  </p>
                                </div> --}}
                                    <button class="alert alert-success ml-auto mr-auto w-100 h-100vh"
                                    style="outline: none; border:none" id="load_more"
                                    data-id="{{ $id }}" type="button" {{--onclick="loadingMore()"--}}>Load More</button>
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
                                            {{-- @php
                                                $idd = [];
                                                foreach($categories as $cate){
                                                    $idd = array_push($cate->id);
                                                }
                                            @endphp --}}
                                            @forelse ($categories as $category)
                                                @forelse ($cats as $cat)
                                                    {{-- @if (count($cats) == count($categories)) --}}
                                                    @if ($cat == $category->id)
                                                        <li><input id="cat_{{$category->id}}" type="checkbox" {{--{{($cat == $category->id ? 'checked':'')}}--}} checked
                                                            attr-name="{{$category->name_en }}" name="cats[]" value="{{$category->id}}" class="filter_checkbox">
                                                            <label for="cat_{{$category->id}}">{{ucfirst($category->name_en)}}</label>
                                                    @else
                                                        @php
                                                            $cat_y = $cats;
                                                            $cat_o = $idd;
                                                            $diffs = array_diff($idd, $cats);
                                                            $diff_values = array_values($diffs);
                                                        @endphp
                                                        @forelse ($diff_values as $diff)
                                                            @if ($diff_values == $category->id)
                                                                <li><input id="cat_{{$category->id}}" type="checkbox"
                                                                    attr-name="{{$category->name_en }}" name="cats[]" value="{{$category->id}}" class="filter_checkbox">
                                                                    <label for="cat_{{$category->id}}">{{ucfirst($category->name_en)}}</label>
                                                            @endif
                                                        @empty
                                                            
                                                        @endforelse
                                                    @endif
                                                    
                                                    {{-- @php
                                                        $cat_y = (array)[];
                                                        $cat_o = (array)[];
                                                        $diffs = (object)[];
                                                    @endphp --}}
                                                    {{-- <li><input id="cat_{{$category->id}}" type="checkbox" 
                                                        attr-name="{{$category->name_en }}" name="cats[]" value="{{$category->id}}" class="filter_checkbox">
                                                        <label for="cat_{{$category->id}}">{{ucfirst($category->name_en)}}</label> --}}
                                                    {{-- @else
                                                        <li><input id="cat_{{$category->id}}" type="checkbox" 
                                                            attr-name="{{$category->name_en }}" name="cats[]" value="{{$category->id}}" class="filter_checkbox">
                                                            <label for="cat_{{$category->id}}">{{ucfirst($category->name_en)}}</label>
                                                    @endif --}}
                                                @empty
                                                    <li><input id="cat_{{$category->id}}" type="checkbox" 
                                                        attr-name="{{$category->name_en }}" name="cats[]" value="{{$category->id}}" class="filter_checkbox">
                                                        <label for="cat_{{$category->id}}">{{ucfirst($category->name_en)}}</label>
                                                @endforelse
                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no categories to show</a>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">By Subcategory</h4>
                                    {{-- <div class="card leftNav cate-sect mb-30">
                                        <p>Refine By:<span class="_t-item_subcategory">(0 items)</span></p>
                                        <div class="" id="subcategoryFilters"></div>
                                    </div> --}}
                                    <div id="subcategorycollapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                        <ul>
                                            @php
                                                $countersubcategory =0;
                                            @endphp
                                            @forelse ($subCategories as $subCategory)
                                                <li><input id="sub_{{$subCategory->id}}" type="checkbox" 
                                                    subcategory-attr-name="{{$subCategory->name_en }}" value="{{$subCategory->id}}" name="subs[]" class="filter_checkbox">
                                                    <label for="sub_{{$subCategory->id}}">{{ucfirst($subCategory->name_en)}}</label>
                                                @php
                                                    $countersubcategory ++;
                                                @endphp
                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no subcategories to show</a>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                    <h4 class="shop-sidebar-title">By Brand</h4>

                                    {{-- <div class="card leftNav cate-sect mb-30">
                                        <p>Refine By:<span class="_t-item_brand">(0 items)</span></p>
                                        <div class="" id="brandFilters"></div>
                                    </div> --}}
                                    <div id="brandcollapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                        <ul>
                                            @php
                                                $counterb =0;
                                            @endphp
                                            @forelse ($brands as $brand)
                                                <li><input id="brand_{{$brand->id}}" type="checkbox"
                                                    brand-attr-name="{{$brand->name_en }}" value="{{$brand->id}}" name="brands[]" class="filter_checkbox">
                                                    <label for="brand_{{$brand->id}}">{{ucfirst($brand->name_en)}}</label>
                                                @php
                                                    $counterb ++;
                                                @endphp
                                            @empty
                                                <li><input type="checkbox"><a href="#">There are no brands to show</a>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </form>
                            <div class="shop-price-filter mt-40 shop-sidebar-border pt-35">
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
                            </div> --}}
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
                            </div>
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
    <script>
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
    </script>
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.filter_checkbox', function () {
                fetchCauseAgainstCategory();
            });
        });

        function fetchCauseAgainstCategory() {
            $('.causes_div').empty();
            $('#filter_form').submit();

            // $('#filter_form').submit(function(){
            //     alert('form submitted');
            // });
            // $.ajax({
            //     type: 'GET',
            //     url: 'filter',
            //     data: $('#filter_form').serialize(),
            //     success: function (response) {
            //         var response = response;
            //         // location.reload();
            //         $('.causes_div').empty();
            //         $('.causes_div').append(response);

            //     }
            // });
        }
    </script>
@endsection
