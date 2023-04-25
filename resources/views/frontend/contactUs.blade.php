@extends('frontend.layout')
@section('title')
    Cybinix Job Portal | Contact Us
@endsection
@section('content')
    <div class="page-content">
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Contact Us</h2>
                        </div>
                    </div>
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li>Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-full twm-contact-one">
            <div class="section-content">
                <div class="container">
                    <div class="contact-one-inner">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="contact-form-outer">
                                    <div class="section-head left wt-small-separator-outer">
                                        <h2 class="wt-title">Send Us a Message</h2>
                                        <p>Feel free to contact us and we will get back to you as soon as we can.</p>
                                    </div>
                                    <form class="" method="POST"
                                        action="{{ route('home.contact.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <input name="name" type="text" required class="form-control"
                                                        placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <input name="email" type="text" class="form-control" required
                                                        placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <input name="phone" type="text" class="form-control" required
                                                        placeholder="Phone">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <input name="subject" type="text" class="form-control" required
                                                        placeholder="Subject">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <textarea name="message" class="form-control" placeholder="Message" style="    height: 190px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="site-button">Submit Now</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="contact-info-wrap">
                                    <div class="contact-info">
                                        <div class="contact-info-section">
                                            <div class="c-info-column">
                                                <div class="c-info-icon"><i class=" fas fa-map-marker-alt"></i></div>
                                                <h3 class="twm-title">In the bay area?</h3>
                                                <p>{{ $address->address }}</p>
                                            </div>
                                            <div class="c-info-column">
                                                <div class="c-info-icon custome-size"><i class="fas fa-mobile-alt"></i>
                                                </div>
                                                <h3 class="twm-title">Feel free to contact us</h3>
                                                <p><a href="tel:+216-761-8331">{{ $address->phone }}</a></p>
                                            </div>
                                            <div class="c-info-column">
                                                <div class="c-info-icon"><i class="fas fa-envelope"></i></div>
                                                <h3 class="twm-title">Support</h3>
                                                <p>{{ $address->email }}</p>
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
@endsection
