@extends('landingpage.layout')
@section('title')
Cybinix Job Portal | Home Page
@endsection
@section('content')
<main>

    <div class="slider-area position-relative ">

        <div class="single-sliders slider-height  gray-bg d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-7">
                        <div class="hero-caption">
                            <span>Easiest way to find a perfect job</span>
                            <h1>Find Your Next Dream Job</h1>

                            <div class="slider-btns">
                                <a href="#" class="btn hero-btn">Looking For a Job?</a>
                                <a href="#" class="hero-btn2">Find Talent</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-tittle">
            <h2>jobs</h2>
        </div>

        <div class="hero-img">
            <img src="{{asset('front')}}/assets/img/hero/hero-img.png" alt="">
        </div>

        <div class="hero-shape bounce-animate">
            <img src="{{asset('front')}}/assets/img/hero/hero-shape.png" alt="">
        </div>

        <div class="hero-shape2">
            <img src="{{asset('front')}}/assets/img/hero/hero-shape2.png" alt="">
        </div>
    </div>


    <section class="top-jobs fix ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-12">

                    <div class="section-tittle section-tittle3 text-center mb-10">
                        <span>1000+</span>
                        <h2>Browse From Our Top Jobs</h2>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="about-area gray-bg section-padding2">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6 col-lg-7 col-md-10">
                    <div class="support-location-img">
                        <img src="{{asset('front')}}/assets/img/gallery/about.png" alt="">
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-10">
                    <div class="right-caption">

                        <div class="section-tittle section-tittle3">
                            <h2>We Build Lasting Relationships Between Candidates & Businesses</h2>
                        </div>
                        <div class="support-caption">
                            <p class="pera-top">Cybinix is a job portal that provides job seekers with access to a range of job opportunities. It allows employers to post job listings and search for suitable candidates, and job seekers to create a profile and apply for jobs. </p>
                            <p class="mb-45">Cybinix aims to simplify the job search process for both employers and job seekers and make it easier for them to connect and find the right match.</p>
                            <a href="#" class="btn about-btn">Find Talent</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="job-category section-padding">
        <div class="container">

            <div class="row justify-content-center mb-55">
                <div class="col-xl-8">
                    <div class="section-tittle section-tittle3 text-center">
                        <h2>Browse From Top Categories</h2>
                    </div>
                </div>
            </div>
            <div class="row" style="    text-align: center;">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat">
                        <div class="cat-icon">
                            <img src="{{asset('front')}}/assets/img/icon/top-cat1.svg" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="#">Design & creatives</a></h5>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat">
                        <div class="cat-icon">
                            <img src="{{asset('front')}}/assets/img/icon/top-cat2.svg" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="#">Finance</a></h5>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat">
                        <div class="cat-icon">
                            <img src="{{asset('front')}}/assets/img/icon/top-cat3.svg" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="#">Marketing</a></h5>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat">
                        <div class="cat-icon">
                            <img src="{{asset('front')}}/assets/img/icon/top-cat4.svg" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="#">Health/Medical</a></h5>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat">
                        <div class="cat-icon">
                            <img src="{{asset('front')}}/assets/img/icon/top-cat5.svg" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="#">Corporate</a></h5>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-cat">
                        <div class="cat-icon">
                            <img src="{{asset('front')}}/assets/img/icon/top-cat6.svg" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="#">Copywriting</a></h5>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="testimonial-area">
        <div class="container">
            <div class="testimonial-wrapper">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="h1-testimonial-active dot-style">

                            <div class="single-testimonial position-relative">
                                <div class="testimonial-caption">
                                    <img src="{{asset('front')}}/assets/img/icon/quotes-sign.png" alt=""
                                        class="quotes-sign">
                                    <p>"The automated process starts as soon as your clothe go into the machine.
                                        This site outcome is
                                        gleaming clothe. Placeholder text commonly used. In publishing and graphic.
                                    </p>
                                </div>

                                <div class="testimonial-founder d-flex align-items-center">
                                    <div class="founder-img">
                                        <img src="{{asset('front')}}/assets/img/icon/testimonial.png" alt="">
                                    </div>
                                    <div class="founder-text">
                                        <span>Robart Brown</span>
                                        <p>Creative designer at Colorlib</p>
                                    </div>
                                </div>
                            </div>

                            <div class="single-testimonial position-relative">
                                <div class="testimonial-caption">
                                    <img src="{{asset('front')}}/assets/img/icon/quotes-sign.png" alt=""
                                        class="quotes-sign">
                                    <p>"The automated process starts as soon as your clothe go into the machine.
                                        This site outcome is
                                        gleaming clothe. Placeholder text commonly used. In publishing and graphic.
                                    </p>
                                </div>

                                <div class="testimonial-founder d-flex align-items-center">
                                    <div class="founder-img">
                                        <img src="{{asset('front')}}/assets/img/icon/testimonial.png" alt="">
                                    </div>
                                    <div class="founder-text">
                                        <span>Robart Brown</span>
                                        <p>Creative designer at Colorlib</p>
                                    </div>
                                </div>
                            </div>

                            <div class="single-testimonial position-relative">
                                <div class="testimonial-caption">
                                    <img src="{{asset('front')}}/assets/img/icon/quotes-sign.png" alt=""
                                        class="quotes-sign">
                                    <p>"The automated process starts as soon as your clothe go into the machine.
                                        This site outcome is
                                        gleaming clothe. Placeholder text commonly used. In publishing and graphic.
                                    </p>
                                </div>

                                <div class="testimonial-founder d-flex align-items-center">
                                    <div class="founder-img">
                                        <img src="{{asset('front')}}/assets/img/icon/testimonial.png" alt="">
                                    </div>
                                    <div class="founder-text">
                                        <span>Robart Brown</span>
                                        <p>Creative designer at Colorlib</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="t-shape">
                    <img src="{{asset('front')}}/assets/img/gallery/testimonial-shape.png" alt="">
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
