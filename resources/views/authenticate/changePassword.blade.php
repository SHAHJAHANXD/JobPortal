@extends('layout')
@section('title')
Cybinix Job Portal | Change Password
@endsection
@section('content')
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12">
                <div class="card" style=" margin-top: 100px;  ">
                    <div class="card-body ">
                        <div class="row m-0">
                            <div class="col-xl-6 col-md-6 sign text-center">
                                <div>

                                    <img src="{{ asset('dashboard/change-password.png') }}" class="education-img">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6" style="margin-top: auto; margin-bottom: auto">
                                <div class="sign-in-your">
                                    <h3>Change Password</h3>
                                    @if (Auth::user()->role == 'Admin')
                                        <form action="{{ route('admin.post.changePassword') }}" method="POST">
                                    @endif
                                    @if (Auth::user()->role == 'Employer')
                                        <form action="{{ route('employer.post.changePassword') }}" method="POST">
                                    @endif
                                    @if (Auth::user()->role == 'Candidate')
                                        <form action="{{ route('candidate.post.changePassword') }}" method="POST">
                                    @endif
                                    @csrf
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Old Password</strong></label>
                                        <input required type="password" class="form-control"
                                            placeholder="Old Password" name="old_password">
                                        @if ($errors->has('old_password'))
                                            <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>New Password</strong></label>
                                        <input required type="password" class="form-control"
                                            placeholder="New Password" name="new_password">
                                        @if ($errors->has('new_password'))
                                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1"><strong>Confirm New Password</strong></label>
                                        <input required type="password" class="form-control"
                                            placeholder="Confirm New Password" name="new_password_confirmation">
                                        @if ($errors->has('new_password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
