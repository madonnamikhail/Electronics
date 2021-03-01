@extends('layouts.dashboard')
@section('title','Show Regions')
@section('link')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
@endsection
@section('content')
{{-- <a href="{{ asset('admin/product/create') }}" class="btn btn-success">Add</a> --}}
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
              <th>{{ __('message.English Name') }}</th>
              <th>{{ __('message.Arabic Name') }}</th>
              <th>{{ __('message.Latitude') }}</th>
              <th>{{ __('message.Logitude') }}</th>
              <th>{{ __('message.city') }}</th>
              <th>{{ __('message.ACTION') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($regions as $region)
                <tr>
                    <td>{{ $region->id }}</td>
                    <td>{{ $region->name_en }}</td>
                    <td>{{ $region->name_ar }}</td>
                    <td>{{ $region->lat }}</td>
                    <td>{{ $region->longg }}</td>
                    <td>{{ $region->city_id }}</td>
                    <td>
                        @php
                            $x=1;
                            $y=2;
                        @endphp
                        <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                            {{-- <a href="#" class="btn btn-success">{{ __('message.Show Regions') }}</a> --}}
                            <a href="{{ route('edit.region', $region->id) }}" class="btn btn-warning">{{ __('message.Edit') }}</a>
                            {{-- <a href="{{ route('update.Message',['id'=>$message->id,'action'=>$x]) }}" class="btn btn-success">In Progress</a> --}}
                            <br>
                            {{-- <a  href="{{ route('update.Message',['id'=>$message->id,'action'=>$y]) }}" class="btn btn-success">Done</a> --}}
                            <br>
                            {{-- <a href="{{ asset('admin/delete/'.$category->id) }}" class="btn btn-warning">Delete</a> --}}
                                <form method="post" action="{{route('delete.region')}}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $region->id }}">
                                    <button class="btn btn-danger form-group  ">{{ __('message.Delete') }}</button>
                                </form>
                            <br>
                            {{-- <div>
                                <a href="{{ asset('admin/product/show/'.$message->id) }}" class="btn btn-warning">{{ __('message.show Products') }}</a>

                            </div> --}}
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


