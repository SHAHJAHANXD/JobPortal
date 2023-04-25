@extends('frontend.layout')
@section('title')
    Cybinix Job Portal | Job Detail
@endsection
@section('content')
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">IT Department Manager</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Job Detail</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->



        <!-- OUR BLOG START -->
        <div class="section-full  p-t120 p-b90 bg-white">
            <div class="container">

                <!-- BLOG SECTION START -->
                <div class="section-content">
                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-8 col-md-12">
                            <!-- Candidate detail START -->
                            <div class="cabdidate-de-info">
                                <div class="twm-job-self-wrap">
                                    <div class="twm-job-self-info">
                                        <div class="twm-job-self-top">
                                            <div class="twm-media-bg">
                                                <img src="{{ asset('front') }}/images/job-detail-bg.jpg" alt="#">
                                                <div class="twm-jobs-category green"><span class="twm-bg-green" style="background: red">{{ $PostJob->job_type }}</span>
                                                </div>
                                            </div>
                                            <div class="twm-mid-content">
                                                <div class="twm-media">
                                                    <img src="/c_image/{{ $PostJob->Users->c_image ?? 'N/A' }}" alt="#">
                                                </div>
                                                <h4 class="twm-job-title">{{ $PostJob->title ?? 'N/A' }} <span
                                                        class="twm-job-post-duration">/
                                                        {{ $PostJob->created_at->diffForHumans() ?? 'N/A' }}</span></h4>
                                                <p class="twm-job-address"><i
                                                        class="feather-map-pin"></i>{{ $PostJob->location ?? 'N/A' }},
                                                    Pakistan</p>
                                                <div class="twm-job-self-mid">
                                                    <div class="twm-job-self-mid-left">
                                                        <a href="https://themeforest.net/user/thewebmax/portfolio"
                                                            class="twm-job-websites site-text-primary">{{ $PostJob->Users->c_website ?? 'N/A' }}</a>
                                                    </div>
                                                    <div class="twm-job-apllication-area">Application ends:
                                                        <span class="twm-job-apllication-date">N/A</span>
                                                    </div>
                                                </div>

                                                <div class="twm-job-self-bottom">
                                                    <a class="site-button" href="{{ route('candidate.jobDetailsToApply', $PostJob->id) }}"
                                                        role="button">
                                                        Apply Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <h4 class="twm-s-title">Job Description:</h4>

                                {!! $PostJob->desc !!}

                                <h4 class="twm-s-title">Share Profile</h4>
                                <div class="twm-social-tags">
                                    <a href="javascript:void(0)" class="fb-clr">Facebook</a>
                                    <a href="javascript:void(0)" class="tw-clr">Twitter</a>
                                    <a href="javascript:void(0)" class="link-clr">Linkedin</a>
                                    <a href="javascript:void(0)" class="whats-clr">Whatsapp</a>
                                    <a href="javascript:void(0)" class="pinte-clr">Pinterest</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 rightSidebar">
                            <div class="side-bar mb-4">
                                <div class="twm-s-info2-wrap mb-5">
                                    <div class="twm-s-info2">
                                        <h4 class="section-head-small mb-4">Job Information</h4>
                                        <ul class="twm-job-hilites">
                                            <li>
                                                <i class="fas fa-calendar-alt"></i>
                                                <span class="twm-title">Date Posted</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-eye"></i>
                                                <span class="twm-title">N/A Views</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-file-signature"></i>
                                                <span class="twm-title">{{ $PostJob->recruitments }} Applicants</span>
                                            </li>
                                        </ul>
                                        <ul class="twm-job-hilites2">
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span class="twm-title">Date Posted</span>
                                                    <div class="twm-s-info-discription">
                                                        {{ $PostJob->created_at->format('M d, Y') ?? 'N/A' }}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span class="twm-title">Location</span>
                                                    <div class="twm-s-info-discription">{{ $PostJob->location ?? 'N/A' }},
                                                        Pakistan</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-user-tie"></i>
                                                    <span class="twm-title">Job Title</span>
                                                    <div class="twm-s-info-discription">{{ $PostJob->title ?? 'N/A' }}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-clock"></i>
                                                    <span class="twm-title">Experience</span>
                                                    <div class="twm-s-info-discription">{{ $PostJob->experience ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-suitcase"></i>
                                                    <span class="twm-title">Qualification</span>
                                                    <div class="twm-s-info-discription">
                                                        {{ $PostJob->qualification ?? 'N/A' }}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-venus-mars"></i>
                                                    <span class="twm-title">Gender</span>
                                                    <div class="twm-s-info-discription">{{ $PostJob->gender ?? 'N/A' }}</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget tw-sidebar-tags-wrap">
                                    <h4 class="section-head-small mb-4">Job Skills</h4>
                                    <div class="tagcloud">
                                        <a href="javascript:void(0)">{{ $PostJob->skills ?? 'N/A' }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="twm-s-info3-wrap mb-5">
                                <div class="twm-s-info3">
                                    <div class="twm-s-info-logo-section">
                                        <div class="twm-media">
                                            <img src="/c_image/{{ $PostJob->Users->c_image ?? 'N/A' }}" alt="#">
                                        </div>
                                        <h4 class="twm-title">{{ $PostJob->title ?? 'N/A' }}</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-building"></i>
                                                <span class="twm-title">Company</span>
                                                <div class="twm-s-info-discription">{{ $PostJob->Users->c_name ?? 'N/A' }}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-mobile-alt"></i>
                                                <span class="twm-title">Phone</span>
                                                <div class="twm-s-info-discription">{{ $PostJob->Users->c_phone ?? 'N/A' }}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-at"></i>
                                                <span class="twm-title">Email</span>
                                                <div class="twm-s-info-discription">{{ $PostJob->Users->c_email ?? 'N/A' }}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-desktop"></i>
                                                <span class="twm-title">Website</span>
                                                <div class="twm-s-info-discription">{{ $PostJob->Users->c_website ?? 'N/A' }}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="twm-title">Address</span>
                                                <div class="twm-s-info-discription">{{ $PostJob->Users->c_location ?? 'N/A' }}, Pakistan</div>
                                            </div>
                                        </li>
                                    </ul>
                                    <a href="about-1.html" class=" site-button">Vew Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
