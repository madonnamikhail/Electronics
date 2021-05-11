@extends('layouts.site')
@section('title','My Account')
@section('content')
    <div class="col-12">
        {{-- <div class="breadcrumb-area bg-image-3 ptb-150"> --}}
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>MY ACCOUNT</h3>
                    <ul>
                        <li><a style="color: black;" href="{{ route('index.page') }}">Home</a></li>
                        <li class="active" style="color: black;">My Account</li>
                    </ul>
                </div>
            {{-- </div> --}}
        </div>
        @php
            $i=1;
        @endphp
		<!-- Breadcrumb Area End -->
        <!-- my account start -->
        <div class="checkout-area pb-80 pt-100">
            <div class="container">
                <div class="row">
                    <div class="ml-auto mr-auto col-lg-9">
                        <div class="checkout-wrapper">
                            <div id="faq" class="panel-group">
                                <div class="panel panel-default">
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
                                    <br><br>
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>@php echo($i); $i++; @endphp</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                                    </div>
                                    <div id="my-account-1" class="panel-collapse collapse  {{--@php echo(($request->submit_info == null)? 'show' : '') ; @endphp--}}">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>My Account Information</h4>
                                                    <h5>Your Personal Details</h5>
                                                </div>
                                                <div class="row">
                                                    <form action="{{ route('profile.change.info') }}" method="post">
                                                        @csrf
                                                        <div class="col-lg-12 col-md-6">
                                                            <div class="billing-info">
                                                                <label>Name</label>    {{--old('subcategory_id')==$offer->id ? 'selected' : ''
                                                                                            old('$user_info->name') == $user_info->name ?  $user_info->name : old('$user_info->name')}}--}}
                                                                <input type="text" name="name" value="{{ $user_info->name }}" placeholder="Enter your name">
                                                                @error('name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-6">
                                                            <div class="billing-info">
                                                                <label>Phone</label>
                                                                <input type="number" name="phone" value="{{ $user_info->phone }}" placeholder="Enter your phone">
                                                                @error('phone')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="billing-back-btn">
                                                            <div class="billing-back">
                                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                            </div>
                                                            <div class="billing-btn">
                                                                <button type="submit" name="submit_info">Continue</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>@php echo($i); $i++; @endphp</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your email </a></h5>
                                    </div>   {{--  --}}
                                    <div id="my-account-2" class="panel-collapse collapse ">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>Change Email</h4>
                                                    <h5>Your Email</h5>
                                                </div>
                                                <div class="row">
                                                    <form action="{{ route('profile.change.email') }}" method="post">
                                                        @csrf
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>Email</label>
                                                                <input type="email" name="email" value="{{ $user_info->email }}" placeholder="Enter your mail">
                                                            </div>
                                                            @error('email')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="billing-back-btn">
                                                            <div class="billing-back">
                                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                            </div>
                                                            <div class="billing-btn">
                                                                <button type="submit">Continue</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>@php echo($i); $i++; @endphp</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                                    </div>
                                    <div id="my-account-2" class="panel-collapse collapse ">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>Change Password</h4>
                                                    {{-- <h5>Your Password</h5> --}}
                                                </div>
                                                <div class="row">
                                                    <form action="{{ route('profile.change.password') }}" method="post">
                                                        @csrf
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>Current Password</label>
                                                                <input  class ="form-control" type="password" name="old_password" placeholder="Enter your password">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>New Password</label>
                                                                <input class ="form-control" type="password" name="password" placeholder="Enter new password">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label>Confirm New Password</label>
                                                                <input class ="form-control" type="password" name="confirm_password" placeholder="Confirm password">
                                                            </div>
                                                        </div>
                                                        <div class="billing-back-btn">
                                                            <div class="billing-back">
                                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                            </div>
                                                            <div class="billing-btn">
                                                                <button type="submit">Continue</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>@php echo($i); $i++; @endphp</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Modify your address book entries   </a></h5>
                                    </div>
                                    <div id="my-account-3" class="panel-collapse collapse ">
                                        <div class="panel-body">
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper">
                                                    <h4>Address Book Entries</h4>
                                                </div>
                                                {{-- <div class="entries-wrapper"> --}}
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-6 d-flex justify-content-around">
                                                            {{-- <div class="entries-info text-center"> --}}
                                                                @foreach ($addresses as $address)
                                                                @if (!$address)
                                                                    <p>No Address Entered !</p>
                                                                    <button><a href="{{ route('profile.create.address') }}">Add Address</a></button>
                                                                @else
                                                                    <div style="padding:20px; border:#ccc solid 2px;">
                                                                        <p> Flat number: {{ $address->flat }} </p>
                                                                        <p> Building number: {{ $address->building }} </p>
                                                                        <p> Floor Number: {{ $address->floor }} </p>
                                                                        <p> Street Name: {{ $address->street_en }} </p>
                                                                        <p>
                                                                            @foreach ($regions as $region)
                                                                                @if($region->id == $address->region_id)
                                                                                    Region: {{ $region->name_en }}
                                                                                    @php
                                                                                        $region_city_id = $region->city_id;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                        </p>
                                                                        <p>
                                                                            {{-- @foreach ($regions as $region) --}}
                                                                                @foreach ($cities as $city)
                                                                                    @if($city->id == $region_city_id)
                                                                                        City: {{ $city->name_en }}
                                                                                    @endif
                                                                                @endforeach
                                                                            {{-- @endforeach --}}
                                                                        </p>
                                                                        {{-- @endforeach --}}
                                                                            <div class="col-lg-6 col-md-6 ">
                                                                                <div class="entries-edit-delete text-center ">
                                                                                    <a class="edit" href="{{ route('profile.edit.address',$address->id ) }}">Edit</a>
                                                                                    <form action="{{ route('profile.delete.address') }}" method="post">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                                                                                        <button type="submit">Delete</button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                    </div>

                                                                @endif
                                                            @endforeach
                                                            {{-- </div> --}}
                                                        </div>

                                                    </div>
                                                {{-- </div> --}}

                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                    </div>
                                                    <div>
                                                        <button><a href="{{ route('profile.create.address') }}">Add Address</a></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>@php echo($i); $i++; @endphp</span> <a href="{{ route('get.rating') }}">order rating</a></h5>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><span>@php echo($i); $i++; @endphp</span> <a href="wishlist.html">Modify your wish list   </a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
