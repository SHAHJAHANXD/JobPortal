<div class="dlabnav">
    <div class="dlabnav-scroll">

        <ul class="metismenu" id="menu">

            @if (Auth::user()->role == 'Candidate')
                <li><a class="" href="{{ route('candidate.dashboard') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="IconlyHome">
                                    <g id="Home">
                                        <path id="Home_2"
                                            d="M9.13478 20.7733V17.7156C9.13478 16.9351 9.77217 16.3023 10.5584 16.3023H13.4326C13.8102 16.3023 14.1723 16.4512 14.4393 16.7163C14.7063 16.9813 14.8563 17.3408 14.8563 17.7156V20.7733C14.8539 21.0978 14.9821 21.4099 15.2124 21.6402C15.4427 21.8705 15.7561 22 16.0829 22H18.0438C18.9596 22.0023 19.8388 21.6428 20.4872 21.0008C21.1356 20.3588 21.5 19.487 21.5 18.5778V9.86686C21.5 9.13246 21.1721 8.43584 20.6046 7.96467L13.934 2.67587C12.7737 1.74856 11.1111 1.7785 9.98539 2.74698L3.46701 7.96467C2.87274 8.42195 2.51755 9.12064 2.5 9.86686V18.5689C2.5 20.4639 4.04738 22 5.95617 22H7.87229C8.55123 22 9.103 21.4562 9.10792 20.7822L9.13478 20.7733Z"
                                            fill="#130F26" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li><a class="" href="{{ route('candidate.profile') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-user-tie"></i>
                        </div>

                        <span class="nav-text">My Profile</span>
                    </a>
                </li>
                <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-briefcase"></i>
                        </div>
                        <span class="nav-text">Jobs</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('candidate.allJobs') }}">All Jobs</a></li>
                        <li><a href="{{ route('candidate.appliedJobs') }}">Applied Jobs</a></li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->role == 'Employer')
                <li><a class="" href="{{ route('employer.dashboard') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="IconlyHome">
                                    <g id="Home">
                                        <path id="Home_2"
                                            d="M9.13478 20.7733V17.7156C9.13478 16.9351 9.77217 16.3023 10.5584 16.3023H13.4326C13.8102 16.3023 14.1723 16.4512 14.4393 16.7163C14.7063 16.9813 14.8563 17.3408 14.8563 17.7156V20.7733C14.8539 21.0978 14.9821 21.4099 15.2124 21.6402C15.4427 21.8705 15.7561 22 16.0829 22H18.0438C18.9596 22.0023 19.8388 21.6428 20.4872 21.0008C21.1356 20.3588 21.5 19.487 21.5 18.5778V9.86686C21.5 9.13246 21.1721 8.43584 20.6046 7.96467L13.934 2.67587C12.7737 1.74856 11.1111 1.7785 9.98539 2.74698L3.46701 7.96467C2.87274 8.42195 2.51755 9.12064 2.5 9.86686V18.5689C2.5 20.4639 4.04738 22 5.95617 22H7.87229C8.55123 22 9.103 21.4562 9.10792 20.7822L9.13478 20.7733Z"
                                            fill="#130F26" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li><a class="" href="{{ route('employer.profile') }}" aria-expanded="false">
                    <div class="menu-icon">
                        <i class="la la-user-tie"></i>
                    </div>

                    <span class="nav-text">My Profile</span>
                </a>
            </li>
                <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-briefcase"></i>
                        </div>
                        <span class="nav-text">Jobs</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('employer.postNewJob') }}">Post New Job</a></li>
                        <li><a href="{{ route('employer.listAllJobs') }}">List Posted Jobs</a></li>
                        <li><a href="{{ route('employer.appliedJobs') }}">Applied Jobs</a></li>

                    </ul>
                </li>

            @endif
            @if (Auth::user()->role == 'Admin')
                <li><a class="" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="IconlyHome">
                                    <g id="Home">
                                        <path id="Home_2"
                                            d="M9.13478 20.7733V17.7156C9.13478 16.9351 9.77217 16.3023 10.5584 16.3023H13.4326C13.8102 16.3023 14.1723 16.4512 14.4393 16.7163C14.7063 16.9813 14.8563 17.3408 14.8563 17.7156V20.7733C14.8539 21.0978 14.9821 21.4099 15.2124 21.6402C15.4427 21.8705 15.7561 22 16.0829 22H18.0438C18.9596 22.0023 19.8388 21.6428 20.4872 21.0008C21.1356 20.3588 21.5 19.487 21.5 18.5778V9.86686C21.5 9.13246 21.1721 8.43584 20.6046 7.96467L13.934 2.67587C12.7737 1.74856 11.1111 1.7785 9.98539 2.74698L3.46701 7.96467C2.87274 8.42195 2.51755 9.12064 2.5 9.86686V18.5689C2.5 20.4639 4.04738 22 5.95617 22H7.87229C8.55123 22 9.103 21.4562 9.10792 20.7822L9.13478 20.7733Z"
                                            fill="#130F26" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li><a class="" href="{{ route('admin.profile') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-user-tie"></i>
                        </div>

                        <span class="nav-text">My Profile</span>
                    </a>
                </li>
                <li><a class="" href="{{ route('admin.AllCandidates') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-user-friends"></i>
                        </div>

                        <span class="nav-text">All Candidates</span>
                    </a>
                </li>
                <li><a class="" href="{{ route('admin.AllEmployers') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-user-friends"></i>
                        </div>

                        <span class="nav-text">All Employers</span>
                    </a>
                </li>
                <li><a class="" href="{{ route('category.get') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-chain-broken"></i>
                        </div>

                        <span class="nav-text">Category</span>
                    </a>
                </li>
                <li><a class="" href="{{ route('JobType.get') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-xing"></i>
                        </div>
                        <span class="nav-text">Job Type</span>
                    </a>
                </li>
                <li><a class="" href="{{ route('JobSkill.get') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <i class="la la-tags"></i>
                        </div>
                        <span class="nav-text">Job Skills</span>
                    </a>
                </li>
            @endif

            <li>
                @if (Auth::user()->role == 'Admin')
                    <a class="" href="{{ route('admin.changePassword') }}" aria-expanded="false">
                @endif
                @if (Auth::user()->role == 'Candidate')
                    <a class="" href="{{ route('candidate.changePassword') }}" aria-expanded="false">
                @endif
                @if (Auth::user()->role == 'Employer')
                    <a class="" href="{{ route('employer.changePassword') }}" aria-expanded="false">
                @endif

                <div class="menu-icon">
                    <i class="la la-lock"></i>
                </div>
                <span class="nav-text">Change Password</span>

                </a>
            </li>
            <li><a class="" href="{{ route('Logout') }}" aria-expanded="false">
                    <div class="menu-icon">
                        <i class="la la-sign-out"></i>
                    </div>
                    <span class="nav-text">Logout</span>

                </a>
            </li>
        </ul>
    </div>
</div>
