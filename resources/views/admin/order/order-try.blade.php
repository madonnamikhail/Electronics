@extends('layouts.dashboard')
@section('title', 'New Order')
@section('content')
    <div class="col-lg-12">
        <form action="{{ route('admin.place.order') }}" method="post" class="insert-form" id="insert-form">
            @csrf
            <div class="form-group">
                <label>{{ __('message.Select User') }}</label>
                <select class="user" id="user" name="user_id">
                  <option value="0" selected disabled>
                    {{ __('message.Select User') }}
                  </option>
                  @foreach ($users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <h1>Add your order </h1>
                <div class="input-field">
                    <table class="table table-bordered" id="table_field">
                        <tr>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Products</th>
                            <th>Add or Remove</th>
                        </tr>
                        <tr>
                            <td>
                                {{-- <label>{{ __('message.Select Category') }}</label> --}}
                                <select name="category_id[]" class="category" id="category">
                                  <option class="form-control" value="0" selected disabled>
                                    {{ __('message.Select Category') }}
                                  </option>
                                  @foreach ($categories as $category )
                                    <option class="form-control" {{ old('category_id')==$category->id ? 'selected' : '' }} value="{{ $category->id }}">
                                      {{ $category->name_en }}
                                    </option>
                                  @endforeach
                                </select>
                            </td>
                            <td>
                                {{-- <label>{{ __('message.Select Subcategory') }}</label> --}}
                                <select class="subcategory" id="subcategory" name="subcategory_id[]">
                                  <option class="form-control"value="0" selected disabled>
                                    {{ __('message.Select Subcategory') }}
                                  </option>
                                </select>
                            </td>
                            <td>
                                {{-- <label>{{ __('message.Select Product') }}</label> --}}
                                <div class="form-group">
                                    <select class="product" id="product" name="product_id[]">
                                        <option class="form-control" value="0" selected disabled style="width: 500px;">
                                            {{ __('message.Select Product') }}
                                        </option>
                                    </select>
                                </div>

                                <div style="display: none" class="all-data">
                                    <div class="form-group">
                                      <label class="form-control">{{ __('message.Enter Quantity') }} :</label>
                                      <br>
                                      <input class="form-control" type="number" name="quantity[]" placeholder="Enter Quantity">
                                </div>
                            </td>
                            <th>
                                <input class="btn btn-warning" type="button" name="add" id="add" value="Add">
                            </th>
                        </tr>
                    </table>
                    @php
                        $i=0;
                    @endphp
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
                    <center>
                        <input class="btn btn-success" type="submit" name="save" id="save" value="Save Data">

                    </center>
                </div>

            </div>
            <div class="form-group">
                {{-- <button type="submit" class="btn btn-primary">{{ __('message.Select') }}</button> --}}
                <button type="submit" class="btn btn-primary">{{ __('message.Try') }}</button>

            </div>

        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            var html=` <tr>
                            <td>
                                {{-- <label>{{ __('message.Select Category') }}</label> --}}
                                <select name="category_id[]" class="category" id="category">
                                  <option class="form-control" value="0" selected disabled>
                                    {{ __('message.Select Category') }}
                                  </option>
                                  @foreach ($categories as $category )
                                    <option class="form-control" {{ old('category_id')==$category->id ? 'selected' : '' }} value="{{ $category->id }}">
                                      {{ $category->name_en }}
                                    </option>
                                  @endforeach
                                </select>
                            </td>
                            <td>
                                {{-- <label>{{ __('message.Select Subcategory') }}</label> --}}
                                <select class="subcategory" id="subcategory" name="subcategory_id[]">
                                  <option class="form-control"value="0" selected disabled>
                                    {{ __('message.Select Subcategory') }}
                                  </option>
                                </select>
                            </td>
                            <td>
                                {{-- <label>{{ __('message.Select Product') }}</label> --}}
                                <div class="form-group">
                                    <select class="product" id="product" name="product_id[]">
                                        <option class="form-control" value="0" selected disabled style="width: 500px;">
                                            {{ __('message.Select Product') }}
                                        </option>
                                    </select>
                                </div>

                                <div style="display: none" class="all-data">
                                    <div class="form-group">
                                      <label class="form-control">{{ __('message.Enter Quantity') }} :</label>
                                      <br>
                                      <input class="form-control" type="number" name="quantity[]" placeholder="Enter Quantity">
                                </div>
                            </td>
                            <th>
                                <input class="btn btn-danger" type="button" name="remove" id="remove" value="Remove">
                            </th>
                        </tr>`;
                        var x = 1;
                        $('#add').click(function(){
                            $('#table_field').append(html);
                        });
                        $('#table_field').on('click','#remove',function(){
                            $(this).closest('tr').remove();
                        });
        });
    </script>
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
