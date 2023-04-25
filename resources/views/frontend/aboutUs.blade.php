@extends('frontend.layout')
@section('title')
    Cybinix Job Portal | About Us
@endsection
@section('content')
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">About Us</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li>About Us</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- JOBS CATEGORIES SECTION START -->
        <div class="section-full p-t30 p-b30 site-bg-gray twm-job-categories-area2">
            <!-- TITLE START-->
            <div class="section-head center wt-small-separator-outer">
                <div class="wt-small-separator site-text-primary">
                    <div>Jobs by Skills</div>
                </div>
                <h2 class="wt-title">Choose Your Desire Skill</h2>
            </div>
            <div class="container">
                <div class="twm-job-categories-section-2 m-b30">
                    <div class="job-categories-style1 m-b30">
                        <div class="row">
                            @foreach ($jobSkills as $jobSkills)
                            <div class="col-lg-3 col-md-6">
                                <div class="job-categories-block-2 m-b30">
                                    <div class="twm-media">
                                       <img src="{{ $jobSkills->img }}" alt="">
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">{{ number_format(count($jobSkills->JobPostedSkills)) }}</div>
                                        <a href="">{{ $jobSkills->name }}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="text-center job-categories-btn">
                        <a href="job-grid.html" class=" site-button">All Categories</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-full p-t120 p-b90 site-bg-white twm-how-it-work-area2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="section-head left wt-small-separator-outer">
                            <div class="wt-small-separator site-text-primary">
                                <div>How It Works </div>
                            </div>
                            <h2 class="wt-title">Follow our steps we will help you.</h2>
                        </div>
                        <ul class="description-list">
                            <li>
                                <i class="feather-check"></i>
                                Trusted & Quality Job
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                International Job
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                No Extra Charge
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                Top Companies
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="twm-w-process-steps-2-wrap">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-sky-light bg-sky-light-shadow">
                                            <span class="twm-large-number text-clr-sky">01</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('front') }}/images/work-process/icon1.png"
                                                        alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">Register<br>Your Account</h4>
                                            <p>You need to create an account to find the best and preferred job.</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-yellow-light bg-yellow-light-shadow">
                                            <span class="twm-large-number text-clr-yellow">02</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('front') }}/images/work-process/icon4.png"
                                                        alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">Search <br>
                                                Your Job</h4>
                                            <p>You need to create an account to find the best and preferred job.</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-pink-light bg-pink-light-shadow">
                                            <span class="twm-large-number text-clr-pink">03</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('front') }}/images/work-process/icon3.png"
                                                        alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">Apply <br>For Dream Job</h4>
                                            <p>You need to create an account to find the best and preferred job.</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="twm-w-process-steps-2">
                                        <div class="twm-w-pro-top bg-clr-green-light bg-clr-light-shadow">
                                            <span class="twm-large-number text-clr-green">04</span>
                                            <div class="twm-media">
                                                <span><img src="{{ asset('front') }}/images/work-process/icon3.png"
                                                        alt="icon1"></span>
                                            </div>
                                            <h4 class="twm-title">Upload <br>Your Resume</h4>
                                            <p>You need to create an account to find the best and preferred job.</p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="twm-how-it-work-section">

                </div>
            </div>

        </div>
        <!-- HOW IT WORK SECTION END -->

        <!-- EXPLORE NEW LIFE START -->
        <div class="section-full p-t120 p-b120 twm-explore-area bg-cover "
            style="background-image: url(images/background/bg-1.jpg);">
            <div class="container">

                <div class="section-content">
                    <div class="row">

                        <div class="col-lg-4 col-md-12">
                            <div class="twm-explore-media-wrap">
                                <div class="twm-media">
                                    <img src="{{ asset('front') }}/images/gir-large.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12">
                            <div class="twm-explore-content-outer">
                                <div class="twm-explore-content">

                                    <div class="twm-l-line-1"></div>
                                    <div class="twm-l-line-2"></div>

                                    <div class="twm-r-circle-1"></div>
                                    <div class="twm-r-circle-2"></div>

                                    <div class="twm-title-small">Explore New Life</div>
                                    <div class="twm-title-large">
                                        <h2>Don’t just find. be found
                                            put your CV in front of
                                            great employers </h2>

                                    </div>


                                </div>
                                <div class="twm-bold-circle-right"></div>
                                <div class="twm-bold-circle-left"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- EXPLORE NEW LIFE END -->


    </div>
@endsection
