@extends('layout')
@section('title')
    Cybinix Job Portal
@endsection
@section('extra-heads')
    <link href="{{ asset('dashboard') }}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('extra-scripts')
    <script src="{{ asset('dashboard') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('dashboard') }}/js/plugins-init/datatables.init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
@section('content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profile Datatable</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>

                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Gender</th>
                                            <th>experience</th>
                                            <th>Recruitments</th>
                                            <th>Category</th>
                                            <th>Job Type</th>
                                            <th>location</th>
                                            <th>Status</th>
                                            <th>Status Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_jobs as $all_jobs)
                                            <tr>
                                                <td>{{ $all_jobs->title }}</td>
                                                <td><a href="">View</a></td>
                                                <td>{{ $all_jobs->gender }}</td>
                                                <td>{{ $all_jobs->experience }}</td>
                                                <td>{{ $all_jobs->recruitments }}</td>
                                                <td>{{ $all_jobs->category }}</td>
                                                <td>{{ $all_jobs->job_type }}</td>
                                                <td>{{ $all_jobs->location }}</td>
                                                <td>
                                                    @if ($all_jobs->status == 1)
                                                        <span class="badge light badge-success">Published</span>
                                                    @else
                                                        <span class="badge light badge-danger">Drafted</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($all_jobs->status == 0)
                                                        <a href="{{ route('admin.ActivateJob', $all_jobs->id) }}"  class="btn btn-success shadow btn-xs me-1">Publish</a>
                                                    @endif
                                                    @if ($all_jobs->status == 1)
                                                        <a href="{{ route('admin.BlockJob', $all_jobs->id) }}"  class="btn btn-danger shadow btn-xs me-1">Draft</a>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                        <form method="POST" action="">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">

                                                            <button class="btn btn-danger shadow btn-xs sharp"><i
                                                                    class="fa fa-trash"></i></button>

                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
