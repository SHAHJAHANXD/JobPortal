<footer class="footer-light">
    <div class="container">
        <div class="ftr-nw-content">
            <div class="row">
                <div class="col-md-5">
                    <div class="ftr-nw-title">
                        Join our email subscription now to get updates
                        on new jobs and notifications.
                    </div>
                </div>
                <div class="col-md-7">
                    <form action="{{ route('newsletter.store') }}" method="POST">
                        @csrf
                        <div class="ftr-nw-form">
                            <input name="email" class="form-control" placeholder="Enter Your Email" type="text" style="border: 2px solid;">
                            <button class="ftr-nw-subcribe-btn" type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @php
            $address = \App\Models\AddressSetting::where('id', 1)->first();
        @endphp
        <div class="footer-top">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="widget widget_about">
                        <div class="logo-footer clearfix">
                            <a href="{{ route('index') }}"><img src="{{ asset('front/logo.png') }}" alt=""></a>
                        </div>
                        {{-- <p>Many desktop publishing packages and web page editors now.</p> --}}
                        <ul class="ftr-list">
                            <li>
                                <p><span>Address :</span>{{ $address->address }}</p>
                            </li>
                            <li>
                                <p><span>Email :</span>{{ $address->email }}</p>
                            </li>
                            <li>
                                <p><span>Phone :</span>{{ $address->phone }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">For Candidate</h3>
                                <ul>
                                    <li><a href="dashboard.html">User Dashboard</a></li>
                                    <li><a href="dash-resume-alert.html">Alert resume</a></li>
                                    <li><a href="candidate-grid.html">Candidates</a></li>
                                    <li><a href="blog-list.html">Blog List</a></li>
                                    <li><a href="blog-single.html">Blog single</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">For Employers</h3>
                                <ul>
                                    <li><a href="dash-post-job.html">Post Jobs</a></li>
                                    <li><a href="blog-grid.html">Blog Grid</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="job-list.html">Jobs Listing</a></li>
                                    <li><a href="job-detail.html">Jobs details</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">Helpful Resources</h3>
                                <ul>
                                    <li><a href="faq.html">FAQs</a></li>
                                    <li><a href="employer-detail.html">Employer detail</a></li>
                                    <li><a href="dash-my-profile.html">Profile</a></li>
                                    <li><a href="error-404.html">404 Page</a></li>
                                    <li><a href="pricing.html">Pricing</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget widget_services ftr-list-center">
                                <h3 class="widget-title">Quick Links</h3>
                                <ul>
                                    <li><a href="{{ route('index') }}">Home</a></li>
                                    <li><a href="about-1.html">About us</a></li>
                                    <li><a href="dash-bookmark.html">Bookmark</a></li>
                                    <li><a href="job-grid.html">Jobs</a></li>
                                    <li><a href="employer-list.html">Employer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php

                $date = \Carbon\Carbon::now()->format('Y');
                $HomePageSetting = \App\Models\HomePageSetting::first();
        @endphp
        <div class="footer-bottom">
            <div class="footer-bottom-info">
                <div class="footer-copy-right">
                    <span class="copyrights-text">Copyright © {{ $date }} by <a href="https://cybinix.com" target="_block">Cybinix</a> All Rights Reserved.</span>
                </div>
                <ul class="social-icons">
                    <li><a href="{{ $HomePageSetting->facebook }}" class="fab fa-facebook-f"></a></li>
                    <li><a href="{{ $HomePageSetting->twitter }}" class="fab fa-twitter"></a></li>
                    <li><a href="{{ $HomePageSetting->instagram }}" class="fab fa-instagram"></a></li>
                    <li><a href="{{ $HomePageSetting->youtube }}" class="fab fa-youtube"></a></li>
                    <li><a href="{{ $HomePageSetting->whatsapp }}" class="fab fa-whatsapp"></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
