@extends('layout')
@section('title')
    Cybinix Job Portal | Users
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
                                            <th class="text-center">Image</th>
                                            <th class="text-center">First Name</th>
                                            <th class="text-center">Last Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Designation</th>
                                            <th class="text-center">Account Status</th>
                                            <th class="text-center">Account Status Action</th>
                                            <th class="text-center">Account</th>
                                            <th class="text-center">Account Action</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $user)
                                            <tr>
                                                <td class="text-center">
                                                    @if ($user->avatar == true)
                                                        <img class="rounded-circle" width="35" src="{{ $user->avatar }}"
                                                            alt="">
                                                    @else
                                                        <img class="rounded-circle" width="35"
                                                            src="{{ asset('dashboard') }}/images/guest.png" alt="">
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $user->first_name }}</td>
                                                <td class="text-center">{{ $user->last_name }}</td>
                                                <td class="text-center">{{ $user->email }}</td>
                                                <td class="text-center">{{ $user->role }}</td>
                                                <td class="text-center">{{ $user->designation }}</td>
                                                <td class="text-center">
                                                    @if ($user->account_status == 1)
                                                        <span class="badge light badge-success">Approved</span>
                                                    @else
                                                        <span class="badge light badge-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($user->account_status == 0)
                                                        <a href="{{ route('admin.ActivateEmployerAccount', $user->id) }}"  class="btn btn-success shadow btn-xs me-1">Activate</a>
                                                    @endif
                                                    @if ($user->account_status == 1)
                                                        <a href="{{ route('admin.RejectEmployerAccount', $user->id) }}"  class="btn btn-danger shadow btn-xs me-1">Reject</a>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if ($user->status == 1)
                                                        <span class="badge light badge-success">Activated</span>
                                                    @else
                                                        <span class="badge light badge-danger">Blocked</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($user->status == 0)
                                                        <a href="{{ route('admin.UpdateAccountStatus', $user->id) }}"  class="btn btn-success shadow btn-xs me-1">Activate</a>
                                                    @endif
                                                    @if ($user->status == 1)
                                                        <a href="{{ route('admin.UpdateAccountStatus', $user->id) }}"  class="btn btn-danger shadow btn-xs me-1">Block</a>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex" style="    justify-content: center;">
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
