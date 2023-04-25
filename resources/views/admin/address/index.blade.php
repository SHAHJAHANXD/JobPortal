@extends('layout')
@section('title')
    Cybinix Job Portal | AddressSetting
@endsection
@section('extra-heads')
    <link href="{{ asset('dashboard') }}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row" style="justify-content: center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($AddressSetting as $AddressSetting)
                                            <tr>
                                                <td class="text-center">{{ $AddressSetting->id }}</td>
                                                <td class="text-center">{{ $AddressSetting->address }}</td>
                                                <td class="text-center">{{ $AddressSetting->email }}</td>
                                                <td class="text-center">{{ $AddressSetting->phone }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex" style="justify-content: center">
                                                        <a href="{{ route('address.edit', $AddressSetting->id) }}"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                class="fas fa-pencil-alt"></i></a>
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
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Person</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="PersonName" class="form-label d-block">Enter Name</label>
                        <input type="text" id="PersonName" class="form-control w-100 mb-3" placeholder="Username">
                        <label for="PersonPosition" class="form-label d-block">Enter Position</label>
                        <input type="text" id="PersonPosition" class="form-control w-100" placeholder="Position">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal -->
    </div>
@endsection
@section('extra-scripts')
    <script src="{{ asset('dashboard') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('dashboard') }}/js/plugins-init/datatables.init.js"></script>
 
@endsection
