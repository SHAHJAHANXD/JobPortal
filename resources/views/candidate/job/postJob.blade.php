@extends('layout')
@section('title')
Cybinix Job Portal
@endsection
@section('content')
<div class="container h-100">
    <div class="row h-100 align-items-center justify-contain-center">
        <div class="col-xl-12">
            <div class="card" style=" margin-top: 100px;  ">
                <div class="card-body ">
                    <h3 class="text-center">Add new job</h3>
                    <div class="row m-0">
                        <h3>Job Content</h3>
                        <div class="col-xl-6 col-md-6 sign"  style="margin-top: 20px">
                            <div class="mb-3">
                                <label class="mb-1"><strong>Job Title</strong></label>
                                <input required type="text" class="form-control"
                                    placeholder="Enter Job Title" name="new_password">
                                @if ($errors->has('new_password'))
                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
