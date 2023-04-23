@extends('layout')
@section('title')
    Cybinix Job Portal | {{ $PostJob->title }}
@endsection
<style>
    .all-fas-fa-icons {
        color: red;
        font-size: 17px;
        margin-right: 5px;
    }

    svg {
        margin-top: 10px;
    }
</style>
@section('content')
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12 col-lg-12 col-sm-12 offset-lg-1" style="margin-top: 150px;">
                <div style="background-color: var(--bs-card-bg); border-radius: 10px; padding: 30px;">
                    <div class="card-header border-0 pb-0">
                        <h2 class="card-title">Job Title: <span>{{ $PostJob->title }}</span></h2>
                    </div>
                    <div class="card-body pb-0">
                        <form action="{{ route('candidate.jobToApply') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="text" hidden name="employer_id" value="{{ $PostJob->user_id }}">
                                <input type="text" hidden name="job_id" value="{{ $PostJob->id }}">
                                <label class="mb-1"><strong>Add Cover Letter</strong></label>
                                <input required type="text" class="form-control" placeholder="Add Cover Letter"
                                    name="cover_letter">
                                @if ($errors->has('cover_letter'))
                                    <span class="text-danger">{{ $errors->first('cover_letter') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="mb-1"><strong>Upload CV</strong></label>
                                <input required type="file" class="form-control" name="cv" multiple>
                                @if ($errors->has('cv'))
                                    <span class="text-danger">{{ $errors->first('cv') }}</span>
                                @endif
                            </div>
                            <div class="row" style="justify-content: center">
                                <div class="col-3">
                                    <button type="submit" class="btn btn-primary btn-block" style="    padding: 0;
                                    background: no-repeat;
                                    border: none;">
                                        <h5 class="card-title"
                                            style="text-align:center; border-radius: 10px;
                                border: 2px solid;
                                background: black;
                                padding: 10px;">
                                            Apply Now</h5>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
