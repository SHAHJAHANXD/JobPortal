@extends('frontend.layout')
@section('title')
    Cybinix Job Portal | Home
@endsection
@section('content')
    <div class="page-content">
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Jobs</h2>
                        </div>
                    </div>
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li>Jobs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- JOB POST START -->
        <div class="section-full p-t120 p-b90 site-bg-gray twm-bg-ring-wrap2">
            <div class="container">

                <div class="wt-separator-two-part">
                    <div class="row wt-separator-two-part-row">
                        <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-left">
                            <!-- TITLE START-->
                            <div class="section-head left wt-small-separator-outer">
                                <div class="wt-small-separator site-text-primary">
                                    <div>Featured Jobs</div>
                                </div>
                                <h2 class="wt-title">You can actually
                                    invent things here</h2>
                            </div>
                            <!-- TITLE END-->
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-right text-right">
                            <a href="{{ route('candidate.listallJobs') }}" class=" site-button">Browse All Jobs</a>
                        </div>
                    </div>
                </div>

                <div class="section-content">
                    <div class="twm-jobs-grid-wrap">
                        <div class="row">
                            @foreach ($jobs as $jobs)
                                <div class="col-lg-4 col-md-6">
                                    <div class="twm-jobs-featured-style1 m-b30">
                                        <img src="{{ $jobs->Skills->img }}" alt="#"
                                            style="height: 80px; width: 100px;">
                                        <div class="twm-jobs-category green"><span class="twm-bg-green">New</span></div>
                                        <div class="twm-mid-content">
                                            <a href="job-detail.html" class="twm-job-title">
                                                <h4>{{ $jobs->title }}</h4>
                                            </a>
                                        </div>
                                        <div class="twm-bot-content">
                                            <p class="twm-job-address"><i class="feather-map-pin"></i>{{ $jobs->location }}, PK</p>
                                            <span class="twm-job-post-duration">{{ $jobs->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="row" style="justify-content: center;">
                            <div class="col-4" style="    text-align: center;">
                                <a href="{{ $loadmore }}" class=" site-button">Load More Jobs</a>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
