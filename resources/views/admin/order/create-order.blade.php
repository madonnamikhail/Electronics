@extends('layouts.dashboard')
@section('title','Add Order')
@section('content')

<div class="col-12">
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
            Select Category
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
            Select Subcategory
          </option>
        </select>
      </div>
      <div class="col-lg-6 m-1">
        <form action="{{ route('admin.add.to.cart') }}" method="post">
          @csrf
          {{-- <div class="card-body"> --}}

          <div class="form-group">
            <label>{{ __('message.Select Product') }}</label>
            <select class="product" id="product" name="product_id">
              <option value="0" selected disabled>
                Select Product
              </option>
            </select>
          </div>

         <div style="display: none" class="all-data">
          <div class="form-group">
            <label>{{ __('message.Enter Quantity') }}</label>
            <input type="number" name="quantity" placeholder="Enter Quantity">
          </div>

          <div class="form-group">
            <label>{{ __('message.Select User') }}</label>
            <select class="user" id="user" name="user_id">
              <option value="0" selected disabled>
                Select User
              </option>
              @foreach ($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

        <div class="form-group">
          <label>{{ __('message.Select Promocode') }}</label>
          <select class="promocode" id="promocode" name="promocode_id">
            <option value="0" selected disabled>
              Select Promocode
            </option>
            @foreach ($promocodes as $promocode)
                <option value="{{ $promocode->id }}">{{ $promocode->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>{{ __('message.Payment Method') }}</label>
          <ul>
            <li>
              <input type="radio" id="master" name="method_payment" value="0.9">
              <label for="master">{{ __('message.Master Card') }} <span>&nbsp; &nbsp;( 10% Discount ) </span></label><br>
              <input type="number" name="master_number">
            </li>
            
            <li>
                <input type="radio" id="cash" name="method_payment" value="5">
                <label for="cash">{{ __('message.Cash on Delivery') }}<span>&nbsp; &nbsp; ( +5 EGP ) </span></label>
            </li>
          </ul>
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