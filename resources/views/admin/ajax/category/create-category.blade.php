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
            <label for="exampleInputEmail1">Sub Category number</label>
            <input type="number" name="subCategory_num"  class="form-control" id="num" placeholder="Enter number of sub category">
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
      {{-- sub caregory here --}}
        <section id="subCatSec"  style="display:none;">
           <div class="col-9">
             <div id="anchor">
                    <p id="p"> </p>
             </div>
            </div>
        </section>

    </div>


@endsection
@section('script')
    <script>
        $(document).on('click','#save_offer',function(e){
            e.preventDefault();
            var formData = new FormData($('#offerForm')[0]);
            var sub_id=$(this).attr('subcat_id');
            var id="";
            
            console.log(cat_id);
            // formData.push({id : sub_id });
            console.log(formData);

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
            success: successCallback,
            // success: function(data){
            //     id=$('#num').val();
            //         // $('#m').val();
            //         // $('#m').innerHTML=15;
            //         // $('#m').html(JSON.stringify(data.subCategory_num));


            //     // function search(region) {
            //     //     $.ajax({
            //     //         url: 'example.com',
            //     //         method: 'GET',
            //     //         success: successCallback,
            //     //     });
            //     // }
            // },
            error :function(reject){

            }
        });
        });
        function successCallback(data) {
            var x = document.getElementById('num').value;
            $('#subCatSec').show();


                        // console.log(data);
                        //  var x=$('#num').val();
                        // data=document.getElementById('num').innerHTML;
                         var x = document.getElementById('num').value;
                        // document.getElementById('m').innerHTML=x;

                        // function create() {
                            // var h1 = document.createElement('h1');

                            //add header on anchor div
                            let h1 = document.createElement('h1');
                            h1.textContent = "Add SubCategory";
                            let anchor = document.getElementById('anchor');
                            anchor.appendChild(h1);


                        // for(var i = 1 ; i<= x ; i++){
                        //     var html = '<tr>';
                        //     html+= '<td><input type="text" placeholder="Enter Sub-Category Name" name=""> feild</td>';
                        //     html+='</tr>';
                        //     $('#table_body').prepend(html);
                        // }


                        for(var i=1 ; i<=x ; i++){
                            var br = document.createElement("br");

                            let h2 = document.createElement('h2');
                            h2.textContent="Sub Category "+ i;


                            var form = document.createElement("form");
                             form.setAttribute("method", "post");
                             form.setAttribute("action", "submit.php");

                             var SC = document.createElement("input");
                                    SC.setAttribute("type", "text");
                                    SC.setAttribute("name", "subname");
                                    SC.setAttribute("placeholder", "Sub Category Name");


                            var PH = document.createElement("input");
                            PH.setAttribute("type", "file");
                            PH.setAttribute("name", "photo");
                            PH.setAttribute("placeholder", "enter photo");

                            // let select = document.createElement("select");
                            // select.name="category_id";
                            // select.id="category_id";




                            // var select1='<select name="category_id">';
                            //    <?php
                            //         foreach($select_box as $value){
                            //     ?>
                            // select1 += '<option value=""></option>';
                            //     <?php
                            //         }
                            //    ?>


                            // var box_html = '<select><?php $select_box =[1,2,3,4]; foreach ($select_box as $value) {echo "<option>$value</option>"  ;}?> </select>';
                                <?php
                                    // $sel = '<select>';
                                    //     // $select_box =[1,2,3,4];
                                    //     // for($i=1 ; $i<=5 ;$i++ )
                                    //     // {
                                    //     //     echo $i ; // $sel += "<option>$value</option>"  ;
                                    //     // }
                                    //     // $sel+='<option>hghghgh</option>';
                                    // $sel += '</select>';
                                    // echo $sel;
                                    echo '<select><option>kslkjdkdjk</option></select>';
                                ?>



                            form.prepend(h2)
                            form.appendChild(br.cloneNode());
                            form.appendChild(SC);
                            form.appendChild(br.cloneNode());
                            form.appendChild(PH);
                            form.appendChild(br.cloneNode());
                            // form.appendChild(box_html);
                            // form.appendChild(br.cloneNode());

                            document.getElementById('subCatSec').appendChild(form);


                        }





                            // document.body.appendChild(h1);
                        //}

                        // for(var i=1 ; i<x;i++){
                        //     console.log("we are here");

                        // }
                    }

    </script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function () {
          $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
           $('#example2').DataTable({
             "paging": true,
             "lengthChange": false,
             "searching": false,
             "ordering": true,
             "info": true,
             "autoWidth": false,
             "responsive": true,
           });
        });
    </script>
@endsection



