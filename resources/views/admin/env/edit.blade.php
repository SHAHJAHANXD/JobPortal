@extends('layout')
@section('title')
    Cybinix Job Portal | Environment | Edit
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
                                <form method="POST" action="{{ route('env.postEdit') }}">
                                    @csrf
                                    <div class="row">
                                        <h5>Application Setting</h5>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Admin Email</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('ADMIN_EMAIL') }}" name="ADMIN_EMAIL">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">App Url</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('APP_URL') }}" name="APP_URL">
                                            </div>
                                        </div>
                                        <h5>Mailer Setting</h5>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Mail Mailer</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('MAIL_MAILER') }}" name="MAIL_MAILER">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Mail Host</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('MAIL_HOST') }}" name="MAIL_HOST">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Mail Port</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('MAIL_PORT') }}" name="MAIL_PORT">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Mail Username</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('MAIL_USERNAME') }}" name="MAIL_USERNAME">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Mail Password</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('MAIL_PASSWORD') }}" name="MAIL_PASSWORD">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Mail Encryption</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('MAIL_ENCRYPTION') }}" name="MAIL_ENCRYPTION">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Mail From Address</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('MAIL_FROM_ADDRESS') }}" name="MAIL_FROM_ADDRESS">
                                            </div>
                                        </div>
                                        <div class="mb-3" style="text-align: center">
                                            <a href="{{ route('admin.testEmail') }}" class="btn btn-primary btn-sm">Test Email</a>
                                        </div>
                                        <h5>Google Setting</h5>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Google Client ID</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('GOOGLE_CLIENT_ID') }}" name="GOOGLE_CLIENT_ID">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Google Client Secret</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('GOOGLE_CLIENT_SECRET') }}" name="GOOGLE_CLIENT_SECRET">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="">Google Call Back URL</label>
                                                <input type="text" class="form-control input-default"
                                                    value="{{ env('GOOGLE_CLIENT_CALL_BACK_URL') }}" name="GOOGLE_CLIENT_CALL_BACK_URL">
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
