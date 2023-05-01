@extends('layout')
@section('title')
    Cybinix Job Portal | Job Listing
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

                                            <th class="text-center">Job By</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Gender</th>
                                            <th class="text-center">experience</th>
                                            <th class="text-center">Recruitments</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Job Type</th>
                                            <th class="text-center">location</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Status Action</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_jobs as $all_jobs)
                                            <tr>
                                                <td class="text-center">{{ $all_jobs->Users->first_name.' '.$all_jobs->Users->last_name }}</td>
                                                <td class="text-center">{{ $all_jobs->title }}</td>
                                                <td class="text-center"><a href="">View</a></td>
                                                <td class="text-center">{{ $all_jobs->gender }}</td>
                                                <td class="text-center">{{ $all_jobs->experience }}</td>
                                                <td class="text-center">{{ $all_jobs->recruitments }}</td>
                                                <td class="text-center">{{ $all_jobs->category }}</td>
                                                <td class="text-center">{{ $all_jobs->job_type }}</td>
                                                <td class="text-center">{{ $all_jobs->location }}</td>
                                                <td class="text-center">
                                                    @if ($all_jobs->status == 1)
                                                        <span class="badge light badge-success">Published</span>
                                                    @else
                                                        <span class="badge light badge-danger">Drafted</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($all_jobs->status == 0)
                                                        <a href="{{ route('admin.ActivateJob', $all_jobs->id) }}"  class="btn btn-success shadow btn-xs me-1">Publish</a>
                                                    @endif
                                                    @if ($all_jobs->status == 1)
                                                        <a href="{{ route('admin.BlockJob', $all_jobs->id) }}"  class="btn btn-danger shadow btn-xs me-1">Draft</a>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.editJob', $all_jobs->id) }}"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                        <form method="POST" action="{{ route('admin.deleteJob', $all_jobs->id) }}">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">

                                                            <button class="btn btn-danger show_confirm shadow btn-xs sharp"><i
                                                                    class="fa fa-trash"   data-toggle="tooltip" title='Delete'></i></button>

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
