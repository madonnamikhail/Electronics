@extends('layouts.dashboard')
@section('title','Add Order')
@section('content')

<div class="col-12">

  <div class="table-content table-responsive">
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
                <th>{{ __('message.Photo') }}</th>
                <th>{{ __('message.Product Name') }}</th>
                <th>{{ __('message.Price') }}</th>
                <th>{{ __('message.Qty') }}</th>
                {{-- <th>Subtotal</th> --}}
                <th>{{ __('message.ACTION') }}</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i=0;
        @endphp
            @foreach ($products as $product)
                <tr>
                    <td class="product-thumbnail">
                        <a href="#"><img style="width:20%" src="{{ asset('images\product\\'. $product->photo ) }}" alt=""></a>
                    </td>
                    <td class="product-name"><a href="#">{{ $product->name_en }} </a></td>

                    <td class="product-price-cart"><span class="amount">

                        {{ $price[$i] }}
                        @php
                            $i++;
                        @endphp

                    </span></td>
                    <td class="product-quantity">
                        <div class="pro-dec-cart">
                            <p class="cart-plus-minus-box">{{ $product->pivot->quantity }}</p>
                        </div>
                    </td>
                    <td class="product-remove">
                        <a href="{{ route('cart.product.edit', $product->id) }}"><i class="fa fa-pencil"></i></a>
                        <form action="{{ route('admin.cart.product.delete') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button style="display: contents;" type="submit"><a><i class="fa fa-times"></i></a></button>
                        </form>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="cart-shiping-update">
      <a href="{{ route('admin.proceed.checkout', $user_id) }}">{{ __('message.proceed to checkout') }}</a>
  </div>
</div>
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ __('message.New Order') }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

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
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
        </form>

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
