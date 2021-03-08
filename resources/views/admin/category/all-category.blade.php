@extends('layouts.dashboard')
@section('title','all Categories')
@section('link')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
@endsection
@section('content')

    <div class="col-12">
        <div class="col-12">
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
        </div>
        <table id="example2" class="table table-bordered table-hover">
            <thead>

            <tr>
              <th>{{ __('message.ID') }}</th>
              <th>{{ __('message.NAME') }}</th>
              <th>{{ __('message.IMAGE') }}</th>
              <th>{{ __('message.ACTION') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($categorys as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>

                    <td>
                        <img src="{{ asset('images/photo/'.$category->photo) }}" style="width:30%;">
                    </td>
                    <td>
                        <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                          {{-- @hasanyrole('DbAdmin|SuperAdmin|UsersAdmin|StaticPagesAdmin|RepoAndStatisticsAdmin|MessagesAdmin|manager')
                              I am a super-admin!
                          @else
                              I am not a super-admin...
                          @endhasanyrole --}}

                          {{-- @can('Update Database')
                            <a href="{{ asset('admin/edit/'.$category->id) }}" class="btn btn-success">{{ __('message.Edit') }}</a>
                            <br>
                          @endcan --}}


                          {{-- @role('DbAdmin') --}}
                          @if($flag)
                            <a href="{{ asset('admin/edit/'.$category->id) }}" class="btn btn-success">{{ __('message.Edit') }}</a>
                            <br>
                            @endif
                          {{-- @endrole --}}
                            {{-- <a href="{{ asset('admin/delete/'.$category->id) }}" class="btn btn-warning">Delete</a> --}}

                                <form method="post" action="{{route('delete.category')}}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $category->id }}">
                                    <input type="hidden" name="photo" value="{{ $category->photo }}">
                                    <button class="btn btn-danger form-group  ">{{ __('message.Delete') }}</button>
                                </form>
                            <br>
                            <a href="{{asset('admin/subcat/show/'.$category->id)}}" class="btn btn-warning">{{ __('message.show SUB-cATEGORY') }}</a>




                        </div>

                    </td>
                  </tr>
                @endforeach


            </tbody>
          </table>
    </div>


@endsection
@section('script')
<!-- DataTables  & Plugins -->
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


