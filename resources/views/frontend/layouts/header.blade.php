<header class="site-header header-style-3 no-fixed mobile-sider-drawer-menu">
    <div class="sticky-header main-bar-wraper  navbar-expand-lg">
        <div class="main-bar">
            <div class="container-fluid clearfix">
                <div class="logo-header">
                    <div class="logo-header-inner logo-header-one">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('front/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <button id="mobile-side-drawer" data-target=".header-nav" data-toggle="collapse" type="button"
                    class="navbar-toggler collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar icon-bar-first"></span>
                    <span class="icon-bar icon-bar-two"></span>
                    <span class="icon-bar icon-bar-three"></span>
                </button>
                <div class="nav-animation header-nav navbar-collapse collapse d-flex justify-content-center">
                    <ul class="nav navbar-nav">
                        <li class="has-child"><a href="{{ route('index') }}">Home</a></li>
                        <li class="has-child"><a href="{{ route('jobs') }}">Jobs</a> </li>
                        <li class="has-child"><a href="{{ route('aboutUs') }}">About Us</a></li>
                        <li class="has-child"><a href="{{ route('contactUs') }}">Contact Us</a></li>
                    </ul>
                </div>
                <div class="extra-nav header-2-nav">
                    <div class="extra-cell">
                        <div class="header-nav-btn-section">
                            @if (Auth::check() == true)
                                <div class="twm-nav-btn-left">
                                    @if (Auth::user()->role == 'Candidate')
                                        <a class="twm-nav-sign-up" href="{{ route('candidate.dashboard') }}"
                                            role="button">
                                    @endif
                                    @if (Auth::user()->role == 'Admin')
                                        <a class="twm-nav-sign-up" href="{{ route('admin.dashboard') }}" role="button">
                                    @endif
                                    @if (Auth::user()->role == 'Employer')
                                        <a class="twm-nav-sign-up" href="{{ route('employer.dashboard') }}"
                                            role="button">
                                    @endif
                                    <i class="feather-log-in"></i> Dashboard
                                    </a>
                                </div>
                                <div class="twm-nav-btn-right">
                                    <a href="{{ route('Logout') }}" class="twm-nav-post-a-job">
                                        <i class="feather-lock"></i> Logout
                                    </a>
                                </div>
                            @else
                                <div class="twm-nav-btn-left">
                                    <a class="twm-nav-sign-up" href="{{ route('login') }}" role="button">
                                        <i class="feather-log-in"></i> Sign In
                                    </a>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
