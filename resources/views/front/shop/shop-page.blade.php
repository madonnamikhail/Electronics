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
                        <li><a href="index.html">Home</a></li>
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
                        <div class="causes_div">

                        </div>
                        <div class="grid-list-product-wrapper">
                            <div class="product-grid product-view pb-20">
                                <div class="row filter_data causes_div" id="products_container ">
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
                                                    <a href="product-details.html">
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
                                                                </h4><a href="#">{{ $product->name_en }}</a>
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
                            <div class="causes_div">

                            </div>
                            <div class="pagination-total-pages" id="remove_row">
                                {{-- <div class="pagination-style">
                                    <ul>
                                        <li><a class="prev-next prev" href="#"><i class="ion-ios-arrow-left"></i> Prev</a></li>
                                        <li><a class="active" href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">...</a></li>
                                        <li><a href="#">10</a></li>
                                        <li><a class="prev-next next" href="#">Next<i class="ion-ios-arrow-right"></i> </a></li>
                                    </ul>
                                </div>
                                <div class="total-pages">
                                    <p>Showing 1 - 20 of 30 results  </p>
                                </div> --}}
                                    <button class="alert alert-success ml-auto mr-auto w-100 h-100vh" style="outline: none; border:none" id="load_more" data-id="{{ $id }}">Load More</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                            <div class="shop-widget">
                                <h4 class="shop-sidebar-title">Shop By Categories</h4>
                                {{-- <div class="shop-catigory">
                                    <ul id="faq">
                                        <li> <a data-toggle="collapse" data-parent="#faq" href="#shop-catigory-1">Morning Tea <i class="ion-ios-arrow-down"></i></a>
                                            <ul id="shop-catigory-1" class="panel-collapse collapse show">
                                                <li><a href="#">Green</a></li>
                                                <li><a href="#">Herbal</a></li>
                                                <li><a href="#">Loose </a></li>
                                                <li><a href="#">Mate</a></li>
                                                <li><a href="#">Organic</a></li>
                                            </ul>
                                        </li>
                                        <li> <a data-toggle="collapse" data-parent="#faq" href="#shop-catigory-2">Tea Trends<i class="ion-ios-arrow-down"></i></a>
                                            <ul id="shop-catigory-2" class="panel-collapse collapse">
                                                <li><a href="#">Pu'Erh</a></li>
                                                <li><a href="#">Black</a></li>
                                                <li><a href="#">White</a></li>
                                                <li><a href="#">Yellow Tea</a></li>
                                                <li><a href="#">Puer Tea</a></li>
                                            </ul>
                                        </li>
                                        <li> <a data-toggle="collapse" data-parent="#faq" href="#shop-catigory-3">Most Tea Map <i class="ion-ios-arrow-down"></i></a>
                                            <ul id="shop-catigory-3" class="panel-collapse collapse">
                                                <li><a href="#">Green Tea</a></li>
                                                <li><a href="#">Oolong Tea</a></li>
                                                <li><a href="#">Black Tea</a></li>
                                                <li><a href="#">Pu'erh Tea </a></li>
                                                <li><a href="#">Dark Tea</a></li>
                                            </ul>
                                        </li>
                                        <li> <a href="#">Herbal Tea</a> </li>
                                        <li> <a href="#">Rooibos Tea</a></li>
                                        <li> <a href="#">Organic Tea</a></li>
                                    </ul>
                                </div> --}}
                                <div class="card leftNav cate-sect mb-30">
                                    <p>Refine By:<span class="_t-item">(0 items)</span></p>
                                    <div class="" id="catFilters"></div>
                                </div>
                                <div id="collapseTwo" data-parent="#accordionExample" class="sidebar-list-style mt-20 ">
                                    <ul>
                                        @php
                                            $counter =0;
                                        @endphp
                                        @forelse ($categories as $category)
                                            {{-- <li>
                                                <input type="checkbox" {{($counter == 0 ? 'checked' : '')}}
                                                    attr-name="{{$category->name_en}}"
                                                    class="custom-control-input category_checkbox" id="{{$category->id}}">
                                                <label class="custom-control-label"
                                                    for="{{$category->id}}">{{ucfirst($category->name_en)}}</label>
                                            </li> --}}
                                            <li><input id="{{$category->id}}" type="checkbox" {{($counter == 0 ? 'checked':'')}} attr-name="{{$category->name_en }}" class="category_checkbox"><label for="{{$category->id}}">{{ucfirst($category->name_en)}}</label>
                                            @php
                                                $counter ++;
                                            @endphp
                                        @empty
                                            <li><input type="checkbox"><a href="#">There are no cats</a>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="shop-price-filter mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">Price Filter</h4>
                                {{-- <div class="price_filter mt-25">
                                    <span>Range:  $100.00 - 1.300.00 </span>
                                    <div id="slider-range"></div>
                                    <div class="price_slider_amount">
                                        <div class="label-input">
                                            <input type="text" id="amount" name="price"  placeholder="Add Your Price" />
                                        </div>
                                        <button type="button">Filter</button>
                                    </div>
                                </div> --}}
                                <div class="col-lg-12">                                
                                    <div class="list-group">
                                        <h3>Price</h3>
                                        <input type="hidden" id="hidden_minimum_price" value="0" />
                                        <input type="hidden" id="hidden_maximum_price" value="65000" />
                                        <p id="price_show">10 - 5000</p>
                                        <div id="price_range"></div>
                                    </div>                
                                </div>
                                <div class="col-md-9">
                                    <br />
                                   <div class="row ">
                                    </div>
                                </div>
                            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">By Brand</h4>
                                <div class="sidebar-list-style mt-20">
                                    <ul>
                                        <li><input type="checkbox"><a href="#">Green </a>
                                        <li><input type="checkbox"><a href="#">Herbal </a></li>
                                        <li><input type="checkbox"><a href="#">Loose </a></li>
                                        <li><input type="checkbox"><a href="#">Mate </a></li>
                                        <li><input type="checkbox"><a href="#">Organic </a></li>
                                        <li><input type="checkbox"><a href="#">White  </a></li>
                                        <li><input type="checkbox"><a href="#">Yellow Tea </a></li>
                                        <li><input type="checkbox"><a href="#">Puer Tea </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">By Color</h4>
                                <div class="sidebar-list-style mt-20">
                                    <ul>
                                        <li><input type="checkbox"><a href="#">Black </a></li>
                                        <li><input type="checkbox"><a href="#">Blue </a></li>
                                        <li><input type="checkbox"><a href="#">Green </a></li>
                                        <li><input type="checkbox"><a href="#">Grey </a></li>
                                        <li><input type="checkbox"><a href="#">Red</a></li>
                                        <li><input type="checkbox"><a href="#">White  </a></li>
                                        <li><input type="checkbox"><a href="#">Yellow   </a></li>
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
                event.preventDefault();
                
                var id = $('#load_more').data('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                console.log(id);
                // $.ajax({
                //     url: '{{ route('load.more') }}',
                //     type: 'post',
                //     data: {
                //         _token : token ,
                //         id: id}
                //     success: function(response) {
                //         console.log("mmmm");
                //     }
                // });
                // $.when.on('click','#load_more').done(function () {
                    
                // });
                $.ajax({
                    url: '{{ route('load.more') }}',
                    type: 'post',
                    data: {
                    _token : token ,
                    id: id,
                    },
                    // dataType:"text",
                    success: function (response) {
                        if(response != '')  
                        { 
                            console.log("mmmm");
                            $('#remove_row').remove();
                            $('#products_container').append(response);
                        }else{
                            $('#load_more').html("No Data");
                        }
                    },
                });
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.category_checkbox', function () {
                var ids = [];
                var counter = 0;
                $('#catFilters').empty();
                $('.category_checkbox').each(function () {
                    if ($(this).is(":checked")) {
                        ids.push($(this).attr('id'));
                        $('#catFilters').
                        append(`<div class="alert fade show alert-color _add-secon" role="alert"> ${$(this).attr('attr-name')}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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
                    // console.log(response);
                    var t = "looping";
                    // $('.causes_div').append(response);
                    $('.causes_div').append('lpllpllplplpl');

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
    </script>

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
                // data:JSON.stringify({_token : token ,action:action, minimum_price:minimum_price, maximum_price:maximum_price}),
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
            min:50,
            max:5000,
            values:[50, 5000],
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
@endsection
