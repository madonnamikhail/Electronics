@extends('layouts.dashboard')
@section('content')

<div class="col-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Category</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="post" id="offerForm" action="{{ route('ajax.store') }}" enctype="multipart/form-data">
            @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Category English Name</label>
            <input type="text" name="name_en" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Category Arabic Name</label>
            <input type="text" name="name_ar" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Category photo</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text">Upload</span>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button id="save_offer" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>

@endsection
@section('script')
    <script>
        $(document).on('click','#save_offer',function(e){
            e.preventDefault();
            var formData = new FormData($('#offerForm')[0]);
            $.ajax({
            type:'post',
            enctype:"multipart/form-data",
            url:"{{ Route('ajax.store') }}",
            // data:{
            //     '_token' :"{{ csrf_token() }}",
            //     'name_en':$("input[name='name_en']").val(),
            //     'name_ar':$("input[name='name_ar']").val(),
            // },
            data:formData,
            processData:false,
            contentType:false,
            cache:false,
            success: function(data){
                
            },
            error :function(reject){

            }
        });
        });


    </script>
@endsection
