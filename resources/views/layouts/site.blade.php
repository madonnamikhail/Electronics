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
        <link rel="stylesheet" href="css/baseTheme/style.css" type="text/css" media="all" />
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>
    <body>
        <!-- header start -->
        <header class="header-area gray-bg clearfix">
            <div class="header-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="logo">
                                <a href="index.html">
                                    <img alt="" src="{{ asset('assets/img/logo/logo.png') }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-6">
                            <div class="header-bottom-right">
                                <div class="main-menu">
                                    <nav>
                                        <ul>
                                            <li class="top-hover"><a href="index.html">{{ __('message.HOME') }}</a>
                                                <ul class="submenu">
                                                    <li><a href="index.html">home version 1</a></li>
                                                    <li><a href="index-2.html">home version 2</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="about-us.html">about</a></li>
                                            <li class="mega-menu-position top-hover"><a href="{{ route('get.shop') }}">shop</a>
                                                <ul class="mega-menu">
                                                    @foreach (App\Models\Category::get() as $category)
                                                    <li>
                                                        <ul>
                                                            <li class="mega-menu-title">{{ $category->name_en }}</li>
                                                            @foreach(App\Models\Subcategory::get() as $subcategory)
                                                                 @if ($category->id == $subcategory->category_id )
                                                                    <li><a href="shop.html">{{ $subcategory->name_en }}</a></li>
                                                                 @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li><a href="{{route('contact-us.message')}}">contact</a></li>

                                                @guest
                                                    <li class="top-hover">
                                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                            Account
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                                                      </div>
                                                </li>
                                            @else
                                                <li class="top-hover">
                                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                        {{ Auth::user()->name }}
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                                                        </ul>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </li>
                                                @endguest


                                        </ul>
                                    </nav>
                                </div>
								<div class="header-currency">
									<span class="digit">Language <i class="ti-angle-down"></i></span>
									<div class="dollar-submenu">
										<ul>
											<li><a href="#">English</a></li>
											<li><a href="#">Arabic</a></li>

										</ul>
									</div>
								</div>
                                <div class="header-cart">
                                    <a href="#">
                                        <div class="cart-icon">
                                            <i class="ti-shopping-cart"></i>
                                        </div>
                                    </a>
                                    <div class="shopping-cart-content">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow">
                                    <li><a href="#">HOME</a>
                                        <ul>
                                            <li><a href="index.html">home version 1</a></li>
                                            <li><a href="index-2.html">home version 2</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="shop.html"> Shop </a>
                                        <ul>
                                            @foreach (App\Models\Category::get() as $category)
                                                <li><a href="#">{{ $category->name_en }}</a>
                                                    <ul>
                                                        @foreach(App\Models\Subcategory::get() as $subcategory)
                                                            @if ($category->id == $subcategory->category_id )
                                                                <li><a href="shop.html">{{ $subcategory->name_en }}</a></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>   
                                            @endforeach
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('contact-us.message')}}"> Contact us </a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
		<!-- header end -->
		<!-- Slider Start -->
      <div class="container">
          <div class="row">
                @yield('content')
          </div>
      </div>
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
                                        <li><a href="my-account.html">My Account</a></li>
                                        <li><a href="about-us.html">Order History</a></li>
                                        <li><a href="wishlist.html">WishList</a></li>
                                        <li><a href="#">Newsletter</a></li>
                                        <li><a href="about-us.html">Order History</a></li>
                                        <li><a href="#">International Orders</a></li>
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
                                        <li><a href="#">Delivery Information</a></li>
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
        @yield('script')
    </body>

</html>
