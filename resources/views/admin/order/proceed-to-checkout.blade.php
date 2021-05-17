@extends('layouts.dashboard')
@section('titile','Proceed To checkout')
@section('content')
<div class="col-12" style="margin:20px auto ; ">
    <div class="col-lg-12 col-md-12">
        <div class="grand-totall" >
            <div class="title-wrap">
                <h4 class="cart-bottom-title section-bg-gary-cart">Admin Make Order</h4>
            </div>
            <div class="col-lg-6 m-1">
                <label>{{ __('message.Select Category') }}</label>
                <select name="category_id" class="category" id="category">
                  <option value="0" selected disabled>
                    {{ __('message.Select Category') }}
                  </option>
                  @foreach ($categories as $category )
                    <option {{ old('category_id')==$category->id ? 'selected' : '' }} value="{{ $category->id }}">
                      {{ $category->name_en }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-6 m-1">
                <label>{{ __('message.Select Subcategory') }}</label>
                <select class="subcategory" id="subcategory">
                  <option value="0" selected disabled>
                    {{ __('message.Select Subcategory') }}
                  </option>
                </select>
              </div>
              <div class="col-lg-6 m-1">
                <form action="{{ route('admin.add.to.cart') }}" method="post">
                  @csrf
                  <div class="card-body">
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                  <div class="form-group">
                    <label>{{ __('message.Select Product') }}</label>
                    <select class="product" id="product" name="product_id">
                      <option value="0" selected disabled>
                        {{ __('message.Select Product') }}
                      </option>
                    </select>
                  </div>

                 <div style="display: none" class="all-data">
                  <div class="form-group">
                    <label>{{ __('message.Enter Quantity') }}</label>
                    <input type="number" name="quantity" placeholder="Enter Quantity">
                  </div>

                <div class="form-group">
                  <button type="submit" name="submit_name" value="cart" class="btn btn-primary">Add</button>
                </div>
              </div>
                </form>

              </div>

            </div>
            <form method="post" action="{{ route('admin.place.order') }}" enctype="multipart/form-data">
                @csrf
                    <table>
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
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                                $j=0;
                                            @endphp

                                             @foreach ($products as $product)
                                                <tr>
                                                    <td class="product-thumbnail">
                                                        <a href="#"><img style="width:20%" src="{{ asset('images\product\\'. $product->photo ) }}" alt=""></a>
                                                    </td>
                                                    <input type="hidden" name="photo[]" value="{{ $product->photo }}">
                                                    <td class="product-name"><a href="#">{{ $product->name_en }} </a></td>
                                                    <input type="hidden" name="name[]" value="{{ $product->name_en }}">
                                                    <td class="product-price-cart"><span class="amount">
                                                        {{ $priceWithOffer[$j] }}
                                                        @php
                                                            $j++;
                                                        @endphp
                                                    </span></td>
                                                    <input type="hidden" name="price[]" value="{{ $product->price }}">

                                                    <td class="product-quantity">
                                                        <div class="pro-dec-cart">
                                                            <p class="cart-plus-minus-box">{{ $product->pivot->quantity }}</p>
                                                            <input type="hidden" name="quantity[]" value="{{ $product->pivot->quantity }}">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            echo $productPrice[$i];
                                                        @endphp
                                                        <input type="hidden" name="productPrice[]" value="@php  echo $productPrice[$i]; $i++; @endphp">
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </tbody>
                    </table>
                    <div class="d-flex justify-content-around">
                                @forelse  ($addresses as $address)
                                        <div class="col-3" style="border:solid #ccc 1px" >
                                            <input type="radio" id="address{{ $i }}" name="address_id" value="{{ $address->id  }}">
                                            <label for="address{{ $i }}">
                                                    <p> <span style="font-weight:600"> Flat number: </span> {{ $address->flat }}, <br>
                                                        <span style="font-weight:600"> Building number: </span>{{ $address->building }}, <br>
                                                        <span style="font-weight:600"> Floor Number: </span> {{ $address->floor }} , <br>
                                                        <span style="font-weight:600">Street Name: </span> {{ $address->street_en }} , <br>

                                                        @foreach ($regions as $region)
                                                            @if($region->id == $address->region_id)
                                                            <span style="font-weight:600"> Region: </span>{{ $region->name_en }} , <br>
                                                                @php
                                                                    $region_city_id = $region->city_id;
                                                                @endphp
                                                            @endif
                                                        @endforeach

                                                            @foreach ($cities as $city)
                                                                @if($city->id == $region_city_id)
                                                                <span style="font-weight:600">  City: </span> {{ $city->name_en }} , <br>
                                                                @endif
                                                            @endforeach
                                                    </p>
                                                </label>
                                        </div>

                                @php
                                    $i++;
                                @endphp
                        @empty
                            <p>No Address Entered !</p>
                            <button><a href="{{ route('profile.create.address') }}">Add Address</a></button>
                        @endforelse
                    </div>



                    {{-- <h5>{{ __('message.Net Total Price') }} <span>
                        @php
                           $sum= array_sum($productPrice);
                           echo $sum;
                        @endphp
                        EGP
                    </span></h5> --}}
                    <div class="total-shipping">
                        <h5>{{ __('message.Payment Method') }}</h5>
                        <ul>
                            <li>
                            <input type="radio" id="female" name="method_payment" value="0.9">
                            <label for="female">{{ __('message.Master Card') }} <span>&nbsp; &nbsp;( 10% Discount ) </span></label><br>

                        </li>
                        <input type="number" name="master_number" >
                            <li>
                                <input type="radio" id="other" name="method_payment" value="5">
                                <label for="other">{{ __('message.Cash on Delivery') }}<span>&nbsp; &nbsp; ( +5 EGP ) </span></label>

                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                               <h4 class="cart-bottom-title section-bg-gray">Use Promo Code</h4>
                            </div>
                            <div class="discount-code">
                                <p>Enter your Promo code if you have one.</p>
                                    <input type="text"  name="promoCodes_id">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user_id }}">

                    <div class="form-group">
                        <button type="submit" name="submit_name" value="order" class="btn btn-primary">Proceed</button>
                      </div>
                    {{-- <input class="cart-btn-2 w-100" type="submit" name="submit_name" value="order">Proceed to Checkout</button> --}}
                        {{-- <h4 class="grand-totall-title">Grand Total  <span>
                            @php
                                $method_payment=0.9;
                                $grand_total= $sum * $method_payment;
                                echo $grand_total . "EGP";
                            @endphp
                        </span>
                    </h4> --}}

            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
      $(document).ready(function(){
         $(document).on('change','.category', function(){
          //  console.log('ay 7aga');
          var category_id = $(this).val();
          // console.log(category_id);
          var op = " ";
          var div = $(this).parent().parent();
          $.ajax({
            type: 'get',
            url: '{{ URL::to('admin/order/get-subcategories') }}',
            data: {'category_id': category_id},
            success: function(data){
              op += '<option value="0" disabled selected>Select Subcategory</option>';
              for(var i=0; i<data.length; i++){
                // console.log("d5al");
                op += '<option value="'+data[i].id+'">'+data[i].name_en+'</option>';
              }
              div.find('.subcategory').html(" ");
              div.find('.subcategory').append(op);


            },
            error: function(){
              console.log('msh tmaaam');
            },
          });
         });

         ///////////// on change ll subcategory to get l products
         $(document).on('change','.subcategory', function(){
          //  console.log('ay 7aga');
          var subcategory_id = $(this).val();
          // console.log(subcategory_id);
          var op1 = " ";
          var div1 = $(this).parent().parent();
          $.ajax({
            type: 'get',
            url: '{{ URL::to('admin/order/get-products') }}',
            data: {'subcategory_id': subcategory_id},
            success: function(data){

              console.log(data);
                op1 += '<option value="0" disabled selected>Select Products</option>';
              for(var i=0; i<data.length; i++){
                op1 += '<option value="'+data[i].id+'">'+data[i].name_en+'</option>';
              }
              div1.find('.product').html(" ");
              div1.find('.product').append(op1);

              $('.all-data').show();
            },
            error: function(){
              console.log('msh tmaaam');
            },
          });
         });
      });
    </script>
@endsection
