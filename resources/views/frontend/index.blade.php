@extends('frontend.layout')
@section('title')
    Cybinix Job Portal | Home
@endsection
@section('content')
    <div class="page-content">

        <div class="twm-home4-banner-section site-bg-light-purple">
            <div class="row">
                <!--Left Section-->
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="twm-bnr-left-section">
                        <div class="twm-bnr-title-large">Your <span class="site-text-primary">Dream Job </span> in one place
                        </div>
                        <div class="twm-bnr-discription">Find jobs that match your interests with us.</div>
                        <div class="twm-bnr-search-bar">
                            <div class="row">
                                <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                    <button type="button" class="site-button">Find Job</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--right Section-->
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="twm-bnr-right-section anm" data-wow-delay="1000ms" data-speed-x="2" data-speed-y="2">

                        <div class="twm-graphics-h3 twm-bg-line">
                            <img src="{{ asset('front') }}/images/home-4/banner/bg-line.png" alt="">
                        </div>

                        <div class="twm-graphics-user twm-user">
                            <img src="{{ asset('front') }}/images/home-4/banner/user.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-bg-plate">
                            <img src="{{ asset('front') }}/images/home-4/banner/bg-plate.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-checked-plate">
                            <img src="{{ asset('front') }}/images/home-4/banner/checked-plate.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-blue-block">
                            <img src="{{ asset('front') }}/images/home-4/banner/blue-block.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-color-dotts">
                            <img src="{{ asset('front') }}/images/home-4/banner/color-dotts.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-card-large anm" data-speed-y="-2" data-speed-scale="-15"
                            data-speed-opacity="50">
                            <img src="{{ asset('front') }}/images/home-4/banner/card.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-card-s1 anm" data-speed-y="2" data-speed-scale="15"
                            data-speed-opacity="50">
                            <img src="{{ asset('front') }}/images/home-4/banner/card-s1.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-card-s2 anm" data-speed-x="-4" data-speed-scale="-25"
                            data-speed-opacity="50">
                            <img src="{{ asset('front') }}/images/home-4/banner/card-s2.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-white-dotts">
                            <img src="{{ asset('front') }}/images/home-4/banner/white-dotts.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-top-shadow anm" data-speed-x="-16" data-speed-y="2"
                            data-speed-scale="50" data-speed-rotate="25">
                            <img src="{{ asset('front') }}/images/home-4/banner/top-shadow.png" alt="">
                        </div>

                        <div class="twm-graphics-h3 twm-bottom-shadow anm" data-speed-x="16" data-speed-y="2"
                            data-speed-scale="20" data-speed-rotate="25">
                            <img src="{{ asset('front') }}/images/home-4/banner/bottom-shadow.png" alt="">
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <!-- JOBS CATEGORIES SECTION START -->
        {{-- <div class="section-full p-t120 p-b90 site-bg-white twm-job-categories-area3">
        <div class="container">

            <div class="wt-separator-two-part">
                <div class="row wt-separator-two-part-row">
                    <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-left">
                        <!-- TITLE START-->
                        <div class="section-head left wt-small-separator-outer">
                            <div class="wt-small-separator site-text-primary">
                                <div>Jobs by Categories</div>
                            </div>
                            <h2 class="wt-title">Choose Your Desire Category</h2>
                        </div>
                        <!-- TITLE END-->
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-right text-right">
                        <a href="job-list.html" class=" site-button">All Categories</a>
                    </div>
                </div>
            </div>

            <div class="twm-job-categories-section-3 m-b30">

                <div class="job-categories-style3">
                    <div class="row">

                        <!-- COLUMNS 1 -->
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 m-b30">
                            <div class="job-categories-3-wrap">
                                <div class="job-categories-3">
                                    <div class="twm-media">
                                        <div class="flaticon-dashboard"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">9,185 Jobs</div>
                                        <a href="job-detail.html">Business Development</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNS 2 -->
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 m-b30">
                            <div class="job-categories-3-wrap">
                                <div class="job-categories-3">
                                    <div class="twm-media">
                                        <div class="flaticon-project-management"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">3,205 Jobs</div>
                                        <a href="job-detail.html">Project Management</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNS 3 -->
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 m-b30">
                            <div class="job-categories-3-wrap">
                                <div class="job-categories-3">
                                    <div class="twm-media">
                                        <div class="flaticon-note"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">2,100 Jobs</div>
                                        <a href="job-detail.html">Content Writer & Blogging</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNS 4 -->
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 m-b30">
                            <div class="job-categories-3-wrap">
                                <div class="job-categories-3">
                                    <div class="twm-media">
                                        <div class="flaticon-customer-support"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">1,500 Jobs</div>
                                        <a href="job-detail.html">Costomer Services</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNS 5 -->
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 m-b30">
                            <div class="job-categories-3-wrap">
                                <div class="job-categories-3">
                                    <div class="twm-media">
                                        <div class="flaticon-bars"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">9,185 Jobs</div>
                                        <a href="job-detail.html">Accounting Finance</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNS 6 -->
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 m-b30">
                            <div class="job-categories-3-wrap">
                                <div class="job-categories-3">
                                    <div class="twm-media">
                                        <div class="flaticon-user"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">3,205 Jobs</div>
                                        <a href="job-detail.html">Sales and Marketing</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

              </div>

        </div>

    </div> --}}
        <!-- JOBS CATEGORIES SECTION END -->

        <!-- ABOUT SECTION START -->
        <div class="section-full p-t120 p-b90 site-bg-gray twm-about-1-area">

            <div class="container">
                <div class="twm-about-1-section-wrap">
                    <div class="row">

                        <div class="col-lg-6 col-md-12">
                            <div class="twm-about-1-section">
                                <div class="twm-media">
                                    <img src="{{ asset('front') }}/images/home-4/about/ab-1.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="twm-about-1-section-right">
                                <!-- TITLE START-->
                                <div class="section-head left wt-small-separator-outer">
                                    <div class="wt-small-separator site-text-primary">
                                        <div>About </div>
                                    </div>
                                    <h2 class="wt-title">Millions of jobs. Find the
                                        one that’s right for you.</h2>

                                </div>
                                <!-- TITLE END-->
                                <ul class="description-list">
                                    <li>
                                        <i class="feather-check"></i>
                                        Full lifetime access
                                    </li>
                                    <li>
                                        <i class="feather-check"></i>
                                        20+ downloadable resources
                                    </li>
                                    <li>
                                        <i class="feather-check"></i>
                                        Certificate of completion
                                    </li>
                                    <li>
                                        <i class="feather-check"></i>
                                        Free Trial 7 Days
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="twm-about-1-bottom-wrap">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <!--icon-block-1-->
                            <div class="twm-card-blocks">
                                <div class="twm-icon pink">
                                    <img src="{{ asset('front') }}/images/main-slider/slider2/icon-2.png" alt="">
                                </div>
                                <div class="twm-content">
                                    <div class="tw-count-number text-clr-pink">
                                        <span class="counter">99</span> +
                                    </div>
                                    <p class="icon-content-info">Job For Cities</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <!--icon-block-2-->
                            <div class="twm-card-blocks-2">
                                <div class="twm-pics">
                                    <span><img src="{{ asset('front') }}/images/main-slider/slider2/user/u-1.jpg"
                                            alt=""></span>
                                    <span><img src="{{ asset('front') }}/images/main-slider/slider2/user/u-2.jpg"
                                            alt=""></span>
                                    <span><img src="{{ asset('front') }}/images/main-slider/slider2/user/u-3.jpg"
                                            alt=""></span>
                                    <span><img src="{{ asset('front') }}/images/main-slider/slider2/user/u-4.jpg"
                                            alt=""></span>
                                    <span><img src="{{ asset('front') }}/images/main-slider/slider2/user/u-5.jpg"
                                            alt=""></span>
                                    <span><img src="{{ asset('front') }}/images/main-slider/slider2/user/u-6.jpg"
                                            alt=""></span>
                                </div>
                                <div class="twm-content">
                                    <div class="tw-count-number text-clr-green">
                                        <span class="counter">3</span>K+
                                    </div>
                                    <p class="icon-content-info">Jobs Done</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <!--icon-block-3-->
                            <div class="twm-card-blocks">
                                <div class="twm-icon">
                                    <img src="{{ asset('front') }}/images/main-slider/slider2/icon-1.png" alt="">
                                </div>
                                <div class="twm-content">
                                    <div class="tw-count-number text-clr-sky">
                                        <span class="counter">12</span>K+
                                    </div>
                                    <p class="icon-content-info">Companies Jobs</p>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>

        </div>
        <!-- ABOUT SECTION END -->

        <!-- How It Work START -->
        <div class="section-full site-bg-primary twm-how-it-work-1-area">
            <div class="container">

                <div class="section-content">
                    <div class="twm-how-it-work-1-content">
                        <div class="row">

                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <div class="twm-how-it-work-1-left">
                                    <div class="twm-how-it-work-1-section">
                                        <!-- TITLE START-->
                                        <div class="section-head left wt-small-separator-outer">
                                            <div class="wt-small-separator">
                                                <div>How it Works</div>
                                            </div>
                                            <h2>Follow our steps we will help you.</h2>
                                        </div>
                                        <!-- TITLE END-->

                                        <div class="twm-step-section-4">
                                            <ul>
                                                <li>
                                                    <div class="twm-step-count bg-clr-sky-light">01</div>
                                                    <div class="twm-step-content">
                                                        <h4 class="twm-title">Register Your Account</h4>
                                                        <p>You need to create an account to find the best and preferred job.
                                                        </p>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="twm-step-count bg-clr-yellow-light">02</div>
                                                    <div class="twm-step-content">
                                                        <h4 class="twm-title">Search Your Job</h4>
                                                        <p>After creating an account, search for your favorite job.</p>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="twm-step-count bg-clr-pink-light">03</div>
                                                    <div class="twm-step-content">
                                                        <h4 class="twm-title">Apply For Dream Job</h4>
                                                        <p>After creating the account, you have to apply for the desired
                                                            job.</p>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="twm-step-count bg-clr-green-light">04</div>
                                                    <div class="twm-step-content">
                                                        <h4 class="twm-title">Upload Your Resume</h4>
                                                        <p>Upload your resume after filling all the relevant information.
                                                        </p>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-7 col-lg-12 col-md-12">

                                <div class="twm-how-it-right-section">
                                    <div class="twm-media">
                                        <div class="twm-bg-circle"><img
                                                src="{{ asset('front') }}/images/home-4/how-it-work/bg-circle-large.png"
                                                alt=""></div>
                                        <div class="twm-block-left anm" data-speed-x="-4" data-speed-scale="-25"><img
                                                src="{{ asset('front') }}/images/home-4/how-it-work/block-left.png"
                                                alt=""></div>
                                        <div class="twm-block-right anm" data-speed-x="-4" data-speed-scale="-25"><img
                                                src="{{ asset('front') }}/images/home-4/how-it-work/block-right.png"
                                                alt=""></div>
                                        <div class="twm-main-bg anm" data-wow-delay="1000ms" data-speed-x="2"
                                            data-speed-y="2"><img
                                                src="{{ asset('front') }}/images/home-4/how-it-work/main-bg.png"
                                                alt=""></div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- How It Work END -->

        <!-- TOP COMPANIES START -->
        <div class="section-full p-t120 p-b90 site-bg-gray twm-companies-wrap">

            <div class="container">
                <div class="section-content">
                    <div class="owl-carousel home-client-carousel4 owl-btn-vertical-center">

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w1.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w2.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w3.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w4.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w5.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w6.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w1.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w2.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w3.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="ow-client-logo">
                                <div class="client-logo client-logo-media">
                                    <a href="employer-list.html"><img
                                            src="{{ asset('front') }}/images/client-logo2/w5.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- TOP COMPANIES END -->


        <!-- EXPLORE NEW LIFE START -->
        <div class="section-full site-bg-light-purple twm-for-employee-4">
            <div class="container">

                <div class="section-content">
                    <div class="twm-for-employee-content">
                        <div class="row">

                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <div class="twm-explore-content-outer2">
                                    <div class="twm-explore-top-section">

                                        <!-- TITLE START-->
                                        <div class="section-head left wt-small-separator-outer">
                                            <div class="wt-small-separator site-text-primary">
                                                <div>About </div>
                                            </div>
                                            <h2>We help you connect with the organizer</h2>
                                            <p>Get paid easily and security. Use our resources to become independent and
                                                showcase your professional skills.</p>

                                        </div>
                                        <!-- TITLE END-->
                                        <div class="twm-read-more">
                                            <a href="about-1.html" class="site-button">Read More</a>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="col-xl-7 col-lg-12 col-md-12">
                                <div class="twm-explore-right-section">
                                    <div class="twm-media">
                                        <div class="twm-bg-circle"><img
                                                src="{{ asset('front') }}/images/home-4/bg-circle.png" alt="">
                                        </div>
                                        <div class="twm-employee-pic"><img
                                                src="{{ asset('front') }}/images/home-4/employee.png" alt="">
                                        </div>
                                        <div class="twm-shot-pic1  anm" data-speed-x="-4" data-speed-scale="-25"><img
                                                src="{{ asset('front') }}/images/home-4/sq-1.png" alt=""></div>
                                        <div class="twm-shot-pic2 anm" data-wow-delay="1000ms" data-speed-x="2"
                                            data-speed-y="2"><img src="{{ asset('front') }}/images/home-4/triangle.png"
                                                alt=""></div>
                                        <div class="twm-shot-pic3  anm" data-speed-x="-4" data-speed-scale="-25""><img
                                                src="{{ asset('front') }}/images/home-4/circle.png" alt=""></div>
                                    </div>

                                    <!--block 1-->
                                    <div class="counter-outer-two one anm" data-speed-y="-2" data-speed-scale="15"
                                        data-speed-opacity="1">
                                        <div class="icon-content">
                                            <div class="tw-count-number text-clr-yellow-2">
                                                <span class="counter">5</span>M+
                                            </div>
                                            <p class="icon-content-info">Million daily active users</p>
                                        </div>
                                    </div>

                                    <!--block 2-->
                                    <div class="counter-outer-two two anm" data-speed-y="2" data-speed-scale="15"
                                        data-speed-opacity="5">
                                        <div class="icon-content">
                                            <div class="tw-count-number text-clr-green">
                                                <span class="counter">9</span>K+
                                            </div>
                                            <p class="icon-content-info">Open job positions</p>
                                        </div>
                                    </div>

                                    <!--block 3-->
                                    <div class="counter-outer-two three anm" data-speed-x="-4" data-speed-scale="-25">
                                        <div class="icon-content">
                                            <div class="tw-count-number text-clr-pink">
                                                <span class="counter">2</span>M+
                                            </div>
                                            <p class="icon-content-info">Million stories shared</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- EXPLORE NEW LIFE END -->

        {{-- <div class="section-full p-t120 p-b90 site-bg-white tw-pricing-area">

        <div class="container">

            <!-- TITLE START-->
            <div class="section-head left wt-small-separator-outer">
                <div class="wt-small-separator site-text-primary">
                    <div>Choose Your Plan</div>
                </div>
                <h2 class="wt-title">Save up to 10%</h2>
            </div>
            <!-- TITLE END-->

            <div class="section-content">

                <div class="twm-tabs-style-1">
                  <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="Monthly" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" >Monthly</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="annual" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile">Annual</button>
                    </li>

                  </ul>
                  <div class="tab-content" id="myTab3Content">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="Monthly">
                        <div class="pricing-block-outer">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-6 m-b30">
                                    <div class="pricing-table-1">
                                        <div class="p-table-title">
                                            <h4 class="wt-title">
                                                Basic
                                            </h4>
                                        </div>
                                        <div class="p-table-inner">
                                            <div class="p-table-price">
                                                <span>$90/</span>
                                                <p>Monthly</p>
                                            </div>
                                            <div class="p-table-list">
                                                <ul>
                                                    <li><i class="feather-check"></i>1 job posting</li>
                                                    <li class="disable"><i class="feather-x"></i>0 featured job</li>
                                                    <li class="disable"><i class="feather-x"></i>job displayed fo 20 days</li>
                                                    <li class="disable"><i class="feather-x"></i>Premium support 24/7</li>
                                                </ul>
                                            </div>
                                            <div class="p-table-btn">
                                                <a href="about-1.html" class="site-button">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 p-table-highlight m-b30">
                                    <div class="pricing-table-1 circle-yellow">
                                        <div class="p-table-recommended">Recommended</div>
                                        <div class="p-table-title">
                                            <h4 class="wt-title">
                                                Standard
                                            </h4>
                                        </div>
                                        <div class="p-table-inner">

                                            <div class="p-table-price">
                                                <span>$248/</span>
                                                <p>Monthly</p>
                                            </div>
                                            <div class="p-table-list">
                                                <ul>
                                                    <li><i class="feather-check"></i>1 job posting</li>
                                                    <li><i class="feather-check"></i>0 featured job</li>
                                                    <li><i class="feather-check"></i>job displayed fo 20 days</li>
                                                    <li class="disable"><i class="feather-x"></i>Premium support 24/7</li>
                                                </ul>
                                            </div>
                                            <div class="p-table-btn">
                                                <a href="about-1.html" class="site-button">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 m-b30">
                                    <div class="pricing-table-1 circle-pink">
                                        <div class="p-table-title">
                                            <h4 class="wt-title">
                                                Extended
                                            </h4>
                                        </div>
                                        <div class="p-table-inner">
                                            <div class="p-table-price">
                                                <span>$499/</span>
                                                <p>Monthly</p>
                                            </div>
                                            <div class="p-table-list">
                                                <ul>
                                                    <li><i class="feather-check"></i>1 job posting</li>
                                                    <li><i class="feather-check"></i>0 featured job</li>
                                                    <li><i class="feather-check"></i>job displayed fo 20 days</li>
                                                    <li><i class="feather-check"></i>Premium support 24/7</li>
                                                </ul>
                                            </div>
                                            <div class="p-table-btn">
                                                <a href="about-1.html" class="site-button">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="annual">
                        <div class="pricing-block-outer">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-6 m-b30">
                                    <div class="pricing-table-1">
                                        <div class="p-table-title">
                                            <h4 class="wt-title">
                                                Basic
                                            </h4>
                                        </div>
                                        <div class="p-table-inner">
                                            <div class="p-table-price">
                                                <span>$149/</span>
                                                <p>Monthly</p>
                                            </div>
                                            <div class="p-table-list">
                                                <ul>
                                                    <li><i class="feather-check"></i>1 job posting</li>
                                                    <li class="disable"><i class="feather-x"></i>0 featured job</li>
                                                    <li class="disable"><i class="feather-x"></i>job displayed fo 20 days</li>
                                                    <li class="disable"><i class="feather-x"></i>Premium support 24/7</li>
                                                </ul>
                                            </div>
                                            <div class="p-table-btn">
                                                <a href="about-1.html" class="site-button">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 p-table-highlight m-b30">
                                    <div class="pricing-table-1 circle-yellow">
                                        <div class="p-table-recommended">Recommended</div>
                                        <div class="p-table-title">
                                            <h4 class="wt-title">
                                                Standard
                                            </h4>
                                        </div>
                                        <div class="p-table-inner">

                                            <div class="p-table-price">
                                                <span>$499/</span>
                                                <p>Monthly</p>
                                            </div>
                                            <div class="p-table-list">
                                                <ul>
                                                    <li><i class="feather-check"></i>1 job posting</li>
                                                    <li><i class="feather-check"></i>0 featured job</li>
                                                    <li><i class="feather-check"></i>job displayed fo 20 days</li>
                                                    <li class="disable"><i class="feather-x"></i>Premium support 24/7</li>
                                                </ul>
                                            </div>
                                            <div class="p-table-btn">
                                                <a href="about-1.html" class="site-button">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 m-b30">
                                    <div class="pricing-table-1 circle-pink">
                                        <div class="p-table-title">
                                            <h4 class="wt-title">
                                                Extended
                                            </h4>
                                        </div>
                                        <div class="p-table-inner">
                                            <div class="p-table-price">
                                                <span>$1499/</span>
                                                <p>Monthly</p>
                                            </div>
                                            <div class="p-table-list">
                                                <ul>
                                                    <li><i class="feather-check"></i>1 job posting</li>
                                                    <li><i class="feather-check"></i>0 featured job</li>
                                                    <li><i class="feather-check"></i>job displayed fo 20 days</li>
                                                    <li><i class="feather-check"></i>Premium support 24/7</li>
                                                </ul>
                                            </div>
                                            <div class="p-table-btn">
                                                <a href="about-1.html" class="site-button">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                  </div>
                </div>



            </div>

        </div>
    </div> --}}




    </div>
@endsection
