@extends('layout')
@section('title')
    Cybinix Job Portal | Home Page | Edit
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
                            <h4 class="card-title">Edit HomePage Setting</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <h4 class="card-title">Social Media URL Setting</h4>
                                <form method="POST" action="{{ route('homePage.postEdit') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Facebook</label>
                                                <input type="text" name="facebook" class="form-control input-default"
                                                    value="{{ $HomePageSetting->facebook }}" placeholder="Enter URl Here...">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Twitter</label>
                                                <input type="text" name="twitter" class="form-control input-default"
                                                    value="{{ $HomePageSetting->twitter }}" placeholder="Enter URl Here...">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">YouTube</label>
                                                <input type="text" name="youtube" class="form-control input-default"
                                                    value="{{ $HomePageSetting->youtube }}" placeholder="Enter URl Here...">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Instagram</label>
                                                <input type="text" name="instagram" class="form-control input-default"
                                                    value="{{ $HomePageSetting->instagram }}" placeholder="Enter URl Here...">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Whatsapp</label>
                                                <input type="text" name="whatsapp" class="form-control input-default"
                                                    value="{{ $HomePageSetting->whatsapp }}" placeholder="Enter URl Here...">
                                            </div>
                                        </div>

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
