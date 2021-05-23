<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset ('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  @yield('link')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">

            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

            <li class="nav-item active">
              <a class="nav-link" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $properties['native'] }} <span class="sr-only">(current)</span></a>
            </li>
            @endforeach

            {{-- <li>
                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $properties['native'] }}
                </a>
            </li> --}}


          </ul>
        </div>
    </nav>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">{{ __('message.HOME') }}</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">{{ __('message.Contact') }}</a>
      </li>
      {{-- @guest
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
          {{-- {{ Auth::guard('admin')->user }}
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <ul class="submenu">
              <li class="top-hover">
                  <a class="dropdown-item" href="{{ route('admin.logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                   {{ __('Logout') }}
               </a>
              </li>
          </ul>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
              @csrf
          </form>
      </div>
  </li>
  @endguest --}}


    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a  href="{{ route('show.Message') }}" class="dropdown-item dropdown-footer">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">{{ App\Models\Message::count() }}</span>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
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
          {{-- {{ Auth::guard('admin')->user }} --}}
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <ul class="submenu">
              <li class="top-hover">
                  <a class="dropdown-item" href="{{ route('admin.logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                   {{ __('Logout') }}
               </a>
              </li>
          </ul>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
              @csrf
          </form>
      </div>
  </li>
  @endguest


    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <h3 class="d-block m-0" style="color:white;">Dashboard</h3>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

    {{-- Roles --}}
    @role('Super Admin', 'admin')
    <li class="nav-item ">
        <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            {{ __('message.Roles') }}
            <i class="right fas fa-angle-left"></i>
            <span class="badge badge badge-danger badge=pill float-right mr-2"> {{Spatie\Permission\Models\Role::count() }}</span>

        </p>
        </a>
        <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('all.roles') }}" class="nav-link active">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ __('message.All Roles') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('create.role') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ __('message.Add Role') }}</p>
            </a>
        </li>
        </ul>
    </li>

    {{-- Permissions --}}

    <li class="nav-item ">
      <a href="#" class="nav-link active">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
          {{ __('message.Permissions') }}
          <i class="right fas fa-angle-left"></i>
          <span class="badge badge badge-danger badge=pill float-right mr-2"> {{Spatie\Permission\Models\Permission::count() }}</span>

      </p>
      </a>
      <ul class="nav nav-treeview">
      <li class="nav-item">
          <a href="{{ route('all.permissions') }}" class="nav-link active">
          <i class="far fa-circle nav-icon"></i>
          <p>{{ __('message.All Permissions') }}</p>
          </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('create.permission') }}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>{{ __('message.Add Permission') }}</p>
          </a>
      </li>
      </ul>
  </li>

  {{-- Admins --}}

  <li class="nav-item ">
    <a href="#" class="nav-link active">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
        {{ __('message.Admins') }}
        <i class="right fas fa-angle-left"></i>
        <span class="badge badge badge-danger badge=pill float-right mr-2"> {{App\Models\Admin::count() }}</span>

    </p>
    </a>
    <ul class="nav nav-treeview">
    <li class="nav-item">
        <a href="{{ route('all.admins') }}" class="nav-link active">
        <i class="far fa-circle nav-icon"></i>
        <p>{{ __('message.All Admins') }}</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('create.admin') }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>{{ __('message.Add Admin') }}</p>
        </a>
    </li>
    </ul>
</li>
  @endrole

  @role('Super Admin|Sales Admin')
            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Category') }}
                    <i class="right fas fa-angle-left"></i>
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Category::count() }}</span>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ asset('admin/show') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.show Category') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/create') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Add Category') }}</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Sub Category') }}
                    <i class="right fas fa-angle-left"></i>
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Subcategory::count() }}</span>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('show-all-subcategory') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Show Sub Category') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/subcat/create') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Add Sub Category') }}</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Product') }}
                    <i class="right fas fa-angle-left"></i>
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Product::count() }}</span>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ asset('admin/product/show-all') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Show Product') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/product/create') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Add Product') }}</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Brands') }}
                    <i class="right fas fa-angle-left"></i>
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Brand::count() }}</span>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ asset('admin/brand/show-all') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Show Brands') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/brand/create') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Add Brands') }}</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Offers') }}
                    <i class="right fas fa-angle-left"></i>
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Offer::count() }}</span>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('all.offers') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Show Offers') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('add.offer') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Add Offers') }}</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Suppliers') }}
                    <i class="right fas fa-angle-left"></i>
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Supplier::count() }}</span>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('all.suppliers') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Show Suppliers') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('add.supplier') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Add Supplier') }}</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Promo Codes') }}
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Promocode::count() }}</span>
                    <i class="right fas fa-angle-left"></i>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('all.promocodes') }}" class="nav-link active">

                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Show Promo Codes') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('add.promocode') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Add Promo Codes') }}</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    {{ __('message.Orders') }}
                    <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Order::count() }}</span>
                    <i class="right fas fa-angle-left"></i>

                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('show.order') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('message.Show All Orders') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('get.new.order') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('message.Add Order') }}</p>
                  </a>
              </li>
                </ul>
            </li>

@endrole
@role('Super Admin|User-Data Admin')
            {{-- City --}}
            <li class="nav-item ">
              <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                  {{ __('message.Cities') }}
                  <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\City::count() }}</span>
                  <i class="right fas fa-angle-left"></i>

              </p>
              </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="{{ route('all.cities') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('message.Show All Cities') }}</p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.city') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('message.Add Cities') }}</p>
                </a>
            </li>
              </ul>
          </li>

          {{-- Region --}}
          <li class="nav-item ">
            <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                {{ __('message.Regions') }}
                <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Region::count() }}</span>
                <i class="right fas fa-angle-left"></i>

            </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="{{ route('all.regions') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('message.Show All Regions') }}</p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('add.region') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('message.Add Region') }}</p>
                </a>
              </li>
            </ul>
        </li>


        {{-- Address --}}
        <li class="nav-item ">
          <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
              {{ __('message.Addresses') }}
              <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Address::count() }}</span>
              <i class="right fas fa-angle-left"></i>

          </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('all.address') }}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('message.Show All Addresses') }}</p>
                </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('add.address') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ __('message.Add Address') }}</p>
              </a>
            </li>
          </ul>
      </li>
@endrole
@role('Super Admin|Static-Page Admin')
      {{-- Static Pages --}}
      <li class="nav-item ">
        <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            {{ __('message.Static Pages') }}
            <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\StaticPage::count() }}</span>
            <i class="right fas fa-angle-left"></i>

        </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="{{ route('all.staticPages') }}" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ __('message.Show All Static Pages') }}</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('add.staticPage') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ __('message.Add Static Page') }}</p>
            </a>
          </li>
        </ul>
    </li>

@endrole
@role('Super Admin|User-Data Admin')
      {{-- Users --}}
    <li class="nav-item ">
        <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            {{ __('message.Users') }}
            <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\User::count() }}</span>
            <i class="right fas fa-angle-left"></i>

        </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="{{ route('all.users') }}" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ __('message.Show All users') }}</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('add.user') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ __('message.Add User') }}</p>
            </a>
          </li>
        </ul>
    </li>
@endrole
@role('Super Admin|Sales Admin')

      {{-- specs --}}
    <li class="nav-item ">
        <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            {{ __('message.Specs') }}
            <span class="badge badge badge-danger badge=pill float-right mr-2"> {{ App\Models\Spec::count() }}</span>
            <i class="right fas fa-angle-left"></i>

        </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="{{ route('all.speccs') }}" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ __('message.Show All Specs') }}</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('add.specc') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ __('message.Add Spec') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('add.specc.product') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ __('message.Add Spec to Product') }}</p>
            </a>
          </li>
        </ul>
    </li>
    @endrole



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1 class="m-0">Dashboard</h1> --}}
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('index.page') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @yield('content')
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
@yield('script')
</body>
</html>
