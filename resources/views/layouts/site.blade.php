
<!doctype html>
<html class="no-js" lang="zxx">

<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Electronics</title>
        <meta name="description" content="">
        <meta name="robots" content="noindex, follow" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}"> --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logoo.png') }}">
		<!-- all css here -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        {{-- @yield('link') --}}
        <link rel="stylesheet" href="css/baseTheme/style.css" type="text/css" media="all" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

           <!-- jQuery library -->
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
           <!-- price slider includes -->
           <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js" integrity="sha256-0vBSIAi/8FxkNOSKyPEfdGQzFDak1dlqFKBYqBp1yC4=" crossorigin="anonymous"></script>
           {{-- <link rel="stylesheet" href="/path/to/jquery-ui.css"> --}}
            {{-- <script src="/path/to/jquery.min.js"></script> --}}
            {{-- <script src="/path/to/jquery-ui.min.js"></script> --}}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
            <link rel="stylesheet" href="{{ asset('css/price_range_style.css')}}">
            {{-- <script src="{{ asset('js/price_range_script.js') }}"></script> --}}
           <!-- Popper JS -->
           <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
           <!-- Latest compiled JavaScript -->
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
        <style>
            html, body {
                max-width: 100%;
                overflow-x: hidden;
            }
            #l_header {
                width: 100%;
                height:500px;
                /* background: url('{{ asset('images/backgrounds/bg_wall.jpg') }}') no-repeat; */
                background-size: cover;
            }
            #l_div {
                width: 100%;
                height: 500px;
                background: url('{{ asset('images/backgrounds/try.png') }}') no-repeat;
                background-size: contain,cover;
                background-position:center center;
            }
            nav ul li a {
                color: #cca43b !important;
            }
        </style>
        @yield('css')
    </head>
    <body>
        <!-- header start -->
        <section style="width:100% ; height:50px; background-color: #242f40; {{--background-image: linear-gradient(to right, #3CA55C 0%, #B5AC49  51%, #3CA55C  100%);--}}">
            <div class="col-6" style="margin-left:auto; margin-right:auto; padding-top:10px">
                <form action="{{ route('search.box.button') }}" method="post" class="p-3">
                    @csrf
                  <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control form-control-lg rounded-0 border-info"
                     placeholder="Search..." autocomplete="on" required style="width:70%" >
                    {{-- <div class="input-group-append"> --}}
                      <input type="submit" name="submit" value="Search" class="btn btn-info btn-lg rounded-0 form-control form-control-lg border-info" style="width:5%; background-color: #cca43b">
                    {{-- </div> --}}
                  </div>
                </form>
            </div>
            <div class="col-md-12" style="position: relative; margin-top:-18px;margin-left:100px; {{-- z-index:1000; --}}">
                <div class="list-group" id="show-list" style="height:500px;">
                  <!-- Here autocomplete list will be display -->
                  {{-- <a class="list-group-item list-group-item-action border-1" id="product_search"> list1</a> --}}
                </div>
            </div>
        </section>
        <section style="width:100% ; height:90px; background-color: #242f40; {{--background-image: linear-gradient(to right, #3CA55C 0%, #B5AC49  51%, #3CA55C  100%);--}}">
            <div>
                <h1 style="padding:30px 100px; color:white; float:left;">E-Sho<span style="color:#CCA43B;">pp</span>ing</h1>
                {{-- <nav style="padding:30px 100px; color:white; float:right;">hgjhgj</nav> --}}
            </div>
            <div class="col-lg-9 col-md-8 col-6">
                <div class="header-bottom-right" style="justify-content: center; height: 120px;">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li class="top-hover" style="height: 82px;"><a href="{{ route('index.page') }}">{{ __('message.HOME') }}</a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('index.page') }}">home version 1</a></li>
                                        <li><a href="{{ route('index.page') }}">home version 2</a></li>
                                    </ul>
                                </li>
                                <li><a href="about-us.html">about</a></li>
                                <li class="mega-menu-position top-hover" style="padding-right: 35px;"><a href="{{ route('get.shop') }}">shop</a>
                                    <ul class="mega-menu" style="padding-top: 10px;top: 90px;">
                                        @foreach (App\Models\Category::get() as $category)
                                        <li>
                                            <ul>
                                                <li class="mega-menu-title"><a style="font-weight: 600" href="{{route('get.products.by.category.id',$category->id)}}">{{ $category->name_en }}</a></li>
                                                @foreach(App\Models\Subcategory::get() as $subcategory)
                                                     @if ($category->id == $subcategory->category_id )
                                                        <li><a href="{{route('get.products.by.subcategory.id',$subcategory->id)}}">{{ $subcategory->name_en }}</a></li>
                                                     @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li style="padding-right: 15px;"><a href="{{route('contact-us.message')}}">contact</a></li>
                                @guest
                                <li class="top-hover">
                                    <a id="navbarDropdown" style="padding-bottom: 0px;height: 90px;" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Account
                                    </a>
                                        <ul class="submenu">
                                            <li class="top-hover">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                            @if (Route::has('register'))
                                                <li class="top-hover">
                                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                                </li>
                                            @endif
                                        </ul>
                            </li>
                        @else
                            <li class="top-hover">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                    <ul class="submenu">
                                        <li class="top-hover">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="{{ route('get.profile') }}">profile</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('get.cart') }}">cart</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('get.rating') }}">My Orders</a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                {{-- </div> --}}
                            </li>
                            @endguest
                            </ul>
                        </nav>
                    </div>
                    <div class="header-currency" style="padding: 0px 0 0 41px;">
                        <span class="digit" style="line-height: 115px; color:#cca43b">Language <i class="ti-angle-down"></i></span>
                        <div class="dollar-submenu" style="z-index: 10;top: 90px;">
                            <ul>
                                <li><a href="#">English</a></li>
                                <li><a href="#">Arabic</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="header-cart" style="line-height: 115px">
                        <a href="{{ route('get.cart') }}">
                            <div class="cart-icon">
                                <i style="color: #cca43b" class="ti-shopping-cart"></i>
                            </div>
                        </a>
                        {{-- <div class="shopping-cart-content">
                            <ul>
                                <li class="single-shopping-cart">
                                    <div class="shopping-cart-img">
                                        <a href="#"><img alt="" src="{{ asset('assets/img/cart/cart-1.jpg') }}"></a>
                                    </div>
                                    <div class="shopping-cart-title">
                                        <h4><a href="#">Phantom Remote </a></h4>
                                        <h6>Qty: 02</h6>
                                        <span>$260.00</span>
                                    </div>
                                    <div class="shopping-cart-delete">
                                        <a href="#"><i class="ion ion-close"></i></a>
                                    </div>
                                </li>
                                <li class="single-shopping-cart">
                                    <div class="shopping-cart-img">
                                        <a href="#"><img alt="" src="{{ asset('assets/img/cart/cart-2.jpg') }}"></a>
                                    </div>
                                    <div class="shopping-cart-title">
                                        <h4><a href="#">Phantom Remote</a></h4>
                                        <h6>Qty: 02</h6>
                                        <span>$260.00</span>
                                    </div>
                                    <div class="shopping-cart-delete">
                                        <a href="#"><i class="ion ion-close"></i></a>
                                    </div>
                                </li>
                            </ul>
                            <div class="shopping-cart-total">
                                <h4>Shipping : <span>$20.00</span></h4>
                                <h4>Total : <span class="shop-total">$260.00</span></h4>
                            </div>
                            <div class="shopping-cart-btn">
                                <a href="cart-page.html">view cart</a>
                                <a href="checkout.html">checkout</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

        </section>
        <section id="l_header">
            <div id="l_div">

            </div>
        </section>
      {{-- <div class="container">
          <div class="row"> --}}
                @yield('content')
          {{-- </div>
      </div> --}}
        <footer class="footer-area pt-75 gray-bg-3">
            <div class="footer-top gray-bg-3 pb-35">
                <div class="container">
                    <div class="row">
						<div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="footer-widget mb-40">
                                <div class="footer-title mb-25">
                                    <h4>My Account</h4>
                                </div>
                                <div class="footer-content">
                                    <ul>
                                        {{-- @auth --}}
                                        <li><a href="{{ route('get.profile') }}">My Account</a></li>
                                        <li><a href="{{ route('get.rating') }}">Order History</a></li>
                                        <li><a href="{{ route('get.profile') }}">My Addresses</a></li>
                                        <li><a href="#">Newsletter</a></li>
                                        <li><a href="about-us.html">Order History</a></li>

                                        {{-- @endauth --}}

                                    </ul>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="footer-widget mb-40">
                                <div class="footer-title mb-25">
                                    <h4>Information</h4>
                                </div>
                                <div class="footer-content">
                                    <ul>
                                        <li><a href="about-us.html">About Us</a></li>
                                        <li><a href="{{ route('contact-us.message') }}">Contact Us</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Terms & Conditions</a></li>
                                        <li><a href="#">Customer Service</a></li>
                                        <li><a href="#">Return Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="footer-widget mb-40">
                                <div class="footer-title mb-25">
                                    <h4>Quick Links</h4>
                                </div>
                                <div class="footer-content">
                                    <ul>
                                        <li><a href="#">Support Center</a></li>
                                        <li><a href="#">Term & Conditions</a></li>
                                        <li><a href="#">Shipping</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Help</a></li>
                                        <li><a href="#">FAQS</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="footer-widget footer-widget-red footer-black-color mb-40">
                                <div class="footer-title mb-25">
                                    <h4>Contact Us</h4>
                                </div>
                                <div class="footer-about">
                                    <p>Your current address goes to here,120 haka, angladesh</p>
                                    <div class="footer-contact mt-20">
                                        <ul>
                                            <li>(+008) 254 254 254 25487</li>
                                            <li>(+009) 358 587 657 6985</li>
                                        </ul>
                                    </div>
									<div class="footer-contact mt-20">
                                        <ul>
                                            <li>yourmail@example.com</li>
                                            <li>example@admin.com</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom pb-25 pt-25 gray-bg-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="copyright">
                                <p><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="payment-img f-right">
                                <a href="#">
                                    <img alt="" src="{{ asset('assets/img/icon-img/payment.png') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
		<!-- Footer style End -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <!-- Thumbnail Large Image start -->
                                <div class="tab-content">
                                    <div id="pro-1" class="tab-pane fade show active">
                                        <img src="{{ asset('assets/img/product-details/product-detalis-l1.jpg') }}" alt="">
                                    </div>
                                    <div id="pro-2" class="tab-pane fade">
                                        <img src="{{ asset('assets/img/product-details/product-detalis-l2.jpg') }}" alt="">
                                    </div>
                                    <div id="pro-3" class="tab-pane fade">
                                        <img src="{{ asset('assets/img/product-details/product-detalis-l3.jpg') }}" alt="">
                                    </div>
                                    <div id="pro-4" class="tab-pane fade">
                                        <img src="{{ asset('assets/img/product-details/product-detalis-l4.jpg') }}" alt="">
                                    </div>
                                </div>
                                <!-- Thumbnail Large Image End -->
                                <!-- Thumbnail Image End -->
                                <div class="product-thumbnail">
                                    <div class="thumb-menu owl-carousel nav nav-style" role="tablist">
                                        <a class="active" data-toggle="tab" href="#pro-1"><img src="{{ asset('assets/img/product-details/product-detalis-s1.jpg') }}" alt=""></a>
                                        <a data-toggle="tab" href="#pro-2"><img src="{{ asset('assets/img/product-details/product-detalis-s2.jpg') }}" alt=""></a>
                                        <a data-toggle="tab" href="#pro-3"><img src="{{ asset('assets/img/product-details/product-detalis-s3.jpg') }}" alt=""></a>
                                        <a data-toggle="tab" href="#pro-4"><img src="{{ asset('assets/img/product-details/product-detalis-s4.jpg') }}" alt=""></a>
                                    </div>
                                </div>
                                <!-- Thumbnail image end -->
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="modal-pro-content">
                                    <h3>Dutchman's Breeches </h3>
                                    <div class="product-price-wrapper">
                                        <span class="product-price-old">£162.00 </span>
                                        <span>£120.00</span>
                                    </div>
                                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet.</p>
                                    <div class="quick-view-select">
                                        <div class="select-option-part">
                                            <label>Size*</label>
                                            <select class="select">
                                                <option value="">S</option>
                                                <option value="">M</option>
                                                <option value="">L</option>
                                            </select>
                                        </div>
                                        <div class="quickview-color-wrap">
                                            <label>Color*</label>
                                            <div class="quickview-color">
                                                <ul>
                                                    <li class="blue">b</li>
                                                    <li class="red">r</li>
                                                    <li class="pink">p</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="02">
                                        </div>
                                        <button>Add to cart</button>
                                    </div>
                                    <span><i class="fa fa-check"></i> In stock</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end -->


		<!-- all js here -->
        <script src="{{ asset('assets/js/vendor/jquery-1.12.0.min.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/popper.js') }}"></script>

        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/ajax-mail.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script type="text/javascript">
                $(document).ready(function () {
                    // Send Search Text to the server
                    $("#search").keyup(function () {
                        var searchText = $(this).val();
                        var token = $('meta[name="csrf-token"]').attr('content');

                        if (searchText != "") {
                        $.ajax({
                            url: '{{ route('search.box') }}',
                            type: 'post',
                            data: {
                            _token : token ,
                            searchText: searchText,
                            },
                            success: function (response) {
                                console.log(response);
                                $("#show-list").html(response);
                            },
                        });
                        } else {
                        $("#show-list").html("");
                        }
                    });
                    // Set searched text in input field on click of search button
                    $(document).on("click", "#product_search", function () {
                        $("#search").val($(this).text());
                        $("#show-list").html("");
                    });
                    });
        </script>
        @yield('script')
    </body>

</html>
