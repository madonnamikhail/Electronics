@extends('layouts.dashboard')
@section('title','all Offers')
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
              <th>{{ __('message.English Title') }}</th>
              <th>{{ __('message.Arabic Title') }}</th>
              <th>{{ __('message.Discount') }}</th>
              <th>{{ __('message.English Details') }}</th>
              <th>{{ __('message.Arabic Details') }}</th>

              <th>{{ __('message.Start Date') }}</th>
              <th>{{ __('message.Expire Date') }}</th>
              <th>{{ __('message.IMAGE') }}</th>
              <th>ACTION</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($offers as $offers)
                <tr>
                    <td>{{ $offers->id }}</td>
                    <td>{{ $offers->title_en }}</td>
                    <td>{{ $offers->title_ar }}</td>
                    <td>{{ $offers->discount }}</td>
                    <td>{{ $offers->details_en }}</td>
                    <td>{{ $offers->details_ar }}</td>
                    <td>{{ $offers->start_date }}</td>
                    <td>{{ $offers->expire_date }}</td>


                    <td>
                        <img src="{{ asset('images/offers/'.$offers->photo) }}" style="width:30%;">
                    </td>
                    <td>
                        <div style="display: flex;  flex-direction: row; flex-wrap: nowrap; justify-content: space-around;" >
                            <a href="{{ asset('admin/offer/edit/'.$offers->id) }}" class="btn btn-success">{{ __('message.Edit') }}</a>
                            <br>
                                <form method="post" action="{{route('delete.offer')}}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ $offers->id }}">
                                    <input type="hidden" name="photo" value="{{ $offers->photo }}">
                                    <button class="btn btn-danger form-group  ">{{ __('message.Delete') }}</button>
                                </form>
                            <br>
                            <a href="{{route('offers.product',$offers->id)}}" class="btn btn-warning">{{ __('message.show Products') }}</a>
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


