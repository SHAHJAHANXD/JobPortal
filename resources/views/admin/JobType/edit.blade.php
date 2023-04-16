@extends('layout')
@section('title')
    Cybinix Job Portal | JobType | Edit
@endsection
@section('extra-heads')
    <link href="{{ asset('dashboard') }}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('extra-scripts')
    <script src="{{ asset('dashboard') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('dashboard') }}/js/plugins-init/datatables.init.js"></script>
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row" style="justify-content: center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit JobType</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form method="POST" action="{{ route('JobType.postEdit') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" hidden name="id" value="{{ $JobType->id }}">
                                        <input type="text" name="name" class="form-control input-default "
                                            value="{{ $JobType->name }}">
                                    </div>
                                    <div class="mb-3" style="text-align: center">
                                        <button type="subit" class="btn btn-primary btn-sm">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
