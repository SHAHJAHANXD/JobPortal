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
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Experience</strong>
                                <span class="mb-0"><i class="fas fa-sort-numeric-up all-fas-fa-icons"></i>
                                    {{ $PostJob->experience }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Category</strong>
                                <span class="mb-0"><i class="fas fa-oven"></i> {{ $PostJob->category }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Job Type</strong>
                                <span class="mb-0"><i class="fas fa-briefcase all-fas-fa-icons"></i>
                                    {{ $PostJob->job_type }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Job Skills</strong>
                                <span class="mb-0"><img src="{{ $PostJob->Skills->img }}" alt=""
                                        style="    height: 30px;
                                    width: 30px;
                                    margin-right: 5px;">{{ $PostJob->Skills->name }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Gender</strong>
                                @if ($PostJob->gender == 'Male')
                                    <span class="mb-0"><i class="fas fa-male all-fas-fa-icons"></i>
                                        {{ $PostJob->gender }}</span>
                                @endif
                                @if ($PostJob->gender == 'Female')
                                    <span class="mb-0"><i class="fas fa-female all-fas-fa-icons"></i>
                                        {{ $PostJob->gender }}</span>
                                @endif
                            </li>

                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Location</strong>
                                <span class="mb-0"><i class="fas fa-map-marker-alt all-fas-fa-icons"></i>
                                    {{ $PostJob->location }}</span>
                            </li>
                        </ul>
                        <hr>
                        <h2 class="card-title">Job Description</h2>
                        <p>{!! $PostJob->desc !!}</p>
                       <div class="row" style="justify-content: center">
                        <div class="col-3">
                            <a href="{{ route('candidate.jobDetailsToApply',$PostJob->id."?slug=".$PostJob->slug) }}">
                                <h5 class="card-title"
                                    style="text-align:center; border-radius: 10px;
                        border: 2px solid;
                        background: black;
                        padding: 10px;">
                                    Apply Now</h5>
                            </a>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
