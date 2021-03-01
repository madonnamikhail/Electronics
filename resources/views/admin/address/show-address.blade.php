@extends('layouts.dashboard')
@section('title','Show Address')
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
              <th>{{ __('message.Flat') }}</th>
              <th>{{ __('message.Building') }}</th>
              <th>{{ __('message.Floor') }}</th>
              <th>{{ __('message.street english name') }}</th>
              <th>{{ __('message.street arabic name') }}</th>
              <th>{{ __('message.region') }}</th>
              <th>{{ __('message.user') }}</th>
              <th>{{ __('message.ACTION') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($addresses as $address)
                <tr>
                    <td>{{ $address->id }}</td>
                    <td>{{ $address->flat }}</td>
                    <td>{{ $address->building }}</td>
                    <td>{{ $address->floor }}</td>
                    <td>{{ $address->street_en }}</td>
                    <td>{{ $address->street_ar }}</td>
                    <td>
                      @foreach ($regions as $region)
                        @if ($address->region_id == $region->id)
                                {{ $region->name_en }}
                        @endif
                      @endforeach
                    </td>
                    <th>
                      @foreach ($users as $user)
                        @if ($address->user_id == $user->id)
                                {{ $user->name_en }}
                        @endif
                      @endforeach
                    </th>
                    <td>
                        <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                            <a href="{{ route('edit.address', $address->id) }}" class="btn btn-warning">{{ __('message.Edit') }}</a>
                            <br>
                                <form method="post" action="{{route('delete.address')}}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $address->id }}">
                                    <button class="btn btn-danger form-group  ">{{ __('message.Delete') }}</button>
                                </form>
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


