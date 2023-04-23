@extends('layout')
@section('title')
    Cybinix Job Portal
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @if (Auth::user()->role == 'Candidate')
                <div class="row" style="justify-content: center;">
                    <div class="col-lg-6">
                        <div class="profile card card-body px-3 pt-3 pb-0">
                            <div class="profile-head">
                                <div class="profile-info">
                                    <div class="profile-photo" style="margin-top: auto">
                                        <img src="{{ asset('dashboard') }}/images/guest.png"
                                            class="img-fluid rounded-circle" alt="">
                                    </div>
                                    <div class="profile-details">
                                        <div class="profile-name px-3 pt-2">
                                            <p>Name</p>
                                            <h4 class="text-white mb-0">{{ Auth::user()->first_name }}
                                                {{ Auth::user()->last_name }}</h4>
                                        </div>
                                        <div class="profile-email px-2 pt-2">
                                            <p>Email</p>
                                            <h4 class="mb-0">{{ Auth::user()->email }}</h4>

                                        </div>
                                        <div class="dropdown ms-auto">
                                            <a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown"
                                                aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24">
                                                        </rect>
                                                        <circle fill="#000000" cx="5" cy="12" r="2">
                                                        </circle>
                                                        <circle fill="#000000" cx="12" cy="12" r="2">
                                                        </circle>
                                                        <circle fill="#000000" cx="19" cy="12" r="2">
                                                        </circle>
                                                    </g>
                                                </svg></a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li class="dropdown-item">

                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#basicModal"><i
                                                            class="fa fa-user-circle text-primary me-2"></i>Update
                                                        profile</a>
                                                </li>
                                                {{-- <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to
                                            btn-close friends</li>
                                        <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to
                                            group</li>
                                        <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="basicModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Your Profile Here!</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Update Profile</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    <form action="{{ route('candidate.updateProfile') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>First Name</strong></label>
                                                            <input type="text" class="form-control" name="first_name"
                                                                value="{{ $userData->first_name }}">
                                                            @if ($errors->has('first_name'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('first_name') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Last Name</strong></label>
                                                            <input type="text" class="form-control" name="last_name"
                                                                value="{{ $userData->last_name }}">
                                                            @if ($errors->has('last_name'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('last_name') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Email</strong></label>
                                                            <input type="text" disabled class="form-control"
                                                                name="email" value="{{ $userData->email }}">
                                                            @if ($errors->has('email'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('email') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Whatsapp Contact</strong></label>
                                                            <input type="text" class="form-control"
                                                                name="wa_no" value="{{ $userData->wa_no }}">
                                                            @if ($errors->has('wa_no'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('wa_no') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>About me</strong></label>
                                                            <textarea class="form-control" name="about_me" placeholder="Enter Your Biography!">{{ $userData->about_me }}</textarea>
                                                            @if ($errors->has('about_me'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('about_me') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Skills</strong></label>
                                                            <br>
                                                            @php
                                                                $userJobSkills = \App\Models\Skills::where('user_id', Auth::user()->id)
                                                                    ->orderBy('name')
                                                                    ->get();

                                                            @endphp
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Designation</strong></label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Enter Your Designation/Expertise"
                                                                name="designation" value="{{ $userData->designation }}">
                                                            @if ($errors->has('designation'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('designation') }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Experience</strong></label>
                                                            <select name="experience" id="" class="form-control"
                                                                style="background: #2A2A2A">
                                                                <option value="{{ $userData->experience }}">
                                                                    {{ $userData->experience }}</option>
                                                                <option value="Less Then 1 Years">Less Then 1 Years
                                                                </option>
                                                                <option value="1-2 Years">1-2 Years</option>
                                                                <option value="2-3 Years">2-3 Years</option>
                                                                <option value="3-4 Years">3-4 Years</option>
                                                                <option value="4-5 Years">4-5 Years</option>
                                                                <option value="5-6 Years">5-6 Years</option>
                                                                <option value="6-7 Years">6-7 Years</option>
                                                                <option value="7-8 Years">7-8 Years</option>
                                                                <option value="8-9 Years">8-9 Years</option>
                                                                <option value="9-10 Years">9-10 Years</option>
                                                                <option value="More Then 10 Years">More Then 10 Years
                                                                </option>
                                                            </select>
                                                            @if ($errors->has('experience'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('experience') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Availability</strong></label>
                                                            <select name="availability" id=""
                                                                class="form-control" style="background: #2A2A2A">
                                                                <option value="{{ $userData->availability }}">
                                                                    {{ $userData->availability }}</option>
                                                                <option value="1-2 Hours">1-2 Hours</option>
                                                                <option value="3-4 Hours">3-4 Hours</option>
                                                                <option value="5-6 Hours">5-6 Hours</option>
                                                                <option value="7-8 Hours">7-8 Hours</option>
                                                                <option value="9-10 Hours">9-10 Hours</option>
                                                            </select>
                                                            @if ($errors->has('availability'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('availability') }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Age</strong></label>
                                                            <select name="age" id="" class="form-control"
                                                                style="background: #2A2A2A">
                                                                <option value="{{ $userData->age }}">{{ $userData->age }}
                                                                </option>
                                                                <option value="Less Then 15 Years">Less Then 15 Years
                                                                </option>
                                                                <option value="15-20 Years">15-20 Years</option>
                                                                <option value="20-25 Years">20-25 Years</option>
                                                                <option value="25-30 Years">25-30 Years</option>
                                                                <option value="30-35 Years">30-35 Years</option>
                                                                <option value="35-40 Years">35-40 Years</option>
                                                                <option value="40-45 Years">40-45 Years</option>
                                                                <option value="45-50 Years">45-50 Years</option>
                                                                <option value="More Then 50 Years">More Then 50 Years
                                                                </option>
                                                            </select>
                                                            @if ($errors->has('age'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('age') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-1"><strong>Location</strong></label>
                                                            <select name="location" id="" class="form-control"
                                                                style="background: #2A2A2A">
                                                                <option value="{{ $userData->location }}">
                                                                    {{ $userData->location }}</option>
                                                                @foreach ($cities as $cities)
                                                                    <option value="{{ $cities->name }}">
                                                                        {{ $cities->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @if ($errors->has('location'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('location') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-block">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="justify-content: center;">
                    <div class="col-xl-6">
                        <div class="card h-auto">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                                    class="nav-link active show">About Me</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">

                                            <div id="about-me" class="tab-pane fade active show">
                                                <div class="profile-about-me">
                                                    <div class="pt-4 border-bottom-1 pb-3">
                                                        <h4 class="text-primary">About Me</h4>
                                                        <p class="mb-2">{{ Auth::user()->about_me ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                @if (!empty($skills))
                                                    <div class="profile-skills mb-5">
                                                        <h4 class="text-primary mb-2">Skills</h4>
                                                        @foreach ($skills as $skill)
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-primary light btn-xs mb-1">{{ $skill->name ?? 'N/A' }}</a>
                                                        @endforeach

                                                    </div>
                                                @endif
                                                @if (!empty($languageUser))
                                                    <div class="profile-lang  mb-5">
                                                        <h4 class="text-primary mb-2">Language</h4>
                                                        @foreach ($languageUser as $languageUser)
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-primary light btn-xs mb-1">{{ $languageUser->name ?? 'N/A' }}</a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div class="profile-personal-info">
                                                    <h4 class="text-primary mb-4">Personal Information</h4>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Name <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{ Auth::user()->first_name }}
                                                                {{ Auth::user()->last_name }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{ Auth::user()->email }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Whatsapp Contact <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{ Auth::user()->wa_no }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Availability <span
                                                                    class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <span>{{ Auth::user()->availability }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Age <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>{{ Auth::user()->age }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Location <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <span>{{ Auth::user()->location }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Experience <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <span>{{ Auth::user()->experience }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="replyModal">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Post Reply</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <textarea class="form-control" rows="4">Message</textarea>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary btn-sm">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (Auth::user()->role == 'Employer')
            <div class="row" style="justify-content: center;">
                <div class="col-lg-6">
                    <div class="profile card card-body px-3 pt-3 pb-0">
                        <div class="profile-head">
                            <div class="profile-info">
                                <div class="profile-photo" style="margin-top: auto">
                                    <img src="{{ asset('dashboard') }}/images/guest.png"
                                        class="img-fluid rounded-circle" alt="">
                                </div>
                                <div class="profile-details">
                                    <div class="profile-name px-3 pt-2">
                                        <p>Name</p>
                                        <h4 class="text-white mb-0">{{ Auth::user()->first_name }}
                                            {{ Auth::user()->last_name }}</h4>
                                    </div>
                                    <div class="profile-email px-2 pt-2">
                                        <p>Email</p>
                                        <h4 class="mb-0">{{ Auth::user()->email }}</h4>

                                    </div>
                                    <div class="dropdown ms-auto">
                                        <a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown"
                                            aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24">
                                                    </rect>
                                                    <circle fill="#000000" cx="5" cy="12" r="2">
                                                    </circle>
                                                    <circle fill="#000000" cx="12" cy="12" r="2">
                                                    </circle>
                                                    <circle fill="#000000" cx="19" cy="12" r="2">
                                                    </circle>
                                                </g>
                                            </svg></a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li class="dropdown-item">

                                                <a type="button" data-bs-toggle="modal" data-bs-target="#basicModal"><i
                                                        class="fa fa-user-circle text-primary me-2"></i>Update
                                                    profile</a>
                                            </li>
                                            {{-- <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to
                                        btn-close friends</li>
                                    <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to
                                        group</li>
                                    <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="basicModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Your Profile Here!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Update Profile</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="basic-form">
                                                <form action="{{ route('employer.updateProfile') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>First Name</strong></label>
                                                        <input type="text" class="form-control" name="first_name"
                                                            value="{{ $userData->first_name }}">
                                                        @if ($errors->has('first_name'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('first_name') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>Last Name</strong></label>
                                                        <input type="text" class="form-control" name="last_name"
                                                            value="{{ $userData->last_name }}">
                                                        @if ($errors->has('last_name'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('last_name') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>Email</strong></label>
                                                        <input type="text" disabled class="form-control"
                                                            name="email" value="{{ $userData->email }}">
                                                        @if ($errors->has('email'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>About me</strong></label>
                                                        <textarea class="form-control" name="about_me" placeholder="Enter Your Biography!">{{ $userData->about_me }}</textarea>
                                                        @if ($errors->has('about_me'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('about_me') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>Skills</strong></label>
                                                        <br>
                                                        @php
                                                            $userJobSkills = \App\Models\Skills::where('user_id', Auth::user()->id)
                                                                ->orderBy('name')
                                                                ->get();

                                                        @endphp
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>Designation</strong></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Your Designation/Expertise"
                                                            name="designation" value="{{ $userData->designation }}">
                                                        @if ($errors->has('designation'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('designation') }}</span>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>Experience</strong></label>
                                                        <select name="experience" id="" class="form-control"
                                                            style="background: #2A2A2A">
                                                            <option value="{{ $userData->experience }}">
                                                                {{ $userData->experience }}</option>
                                                            <option value="Less Then 1 Years">Less Then 1 Years
                                                            </option>
                                                            <option value="1-2 Years">1-2 Years</option>
                                                            <option value="2-3 Years">2-3 Years</option>
                                                            <option value="3-4 Years">3-4 Years</option>
                                                            <option value="4-5 Years">4-5 Years</option>
                                                            <option value="5-6 Years">5-6 Years</option>
                                                            <option value="6-7 Years">6-7 Years</option>
                                                            <option value="7-8 Years">7-8 Years</option>
                                                            <option value="8-9 Years">8-9 Years</option>
                                                            <option value="9-10 Years">9-10 Years</option>
                                                            <option value="More Then 10 Years">More Then 10 Years
                                                            </option>
                                                        </select>
                                                        @if ($errors->has('experience'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('experience') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>Availability</strong></label>
                                                        <select name="availability" id=""
                                                            class="form-control" style="background: #2A2A2A">
                                                            <option value="{{ $userData->availability }}">
                                                                {{ $userData->availability }}</option>
                                                            <option value="1-2 Hours">1-2 Hours</option>
                                                            <option value="3-4 Hours">3-4 Hours</option>
                                                            <option value="5-6 Hours">5-6 Hours</option>
                                                            <option value="7-8 Hours">7-8 Hours</option>
                                                            <option value="9-10 Hours">9-10 Hours</option>
                                                        </select>
                                                        @if ($errors->has('availability'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('availability') }}</span>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="mb-1"><strong>Age</strong></label>
                                                        <select name="age" id="" class="form-control"
                                                            style="background: #2A2A2A">
                                                            <option value="{{ $userData->age }}">{{ $userData->age }}
                                                            </option>
                                                            <option value="Less Then 15 Years">Less Then 15 Years
                                                            </option>
                                                            <option value="15-20 Years">15-20 Years</option>
                                                            <option value="20-25 Years">20-25 Years</option>
                                                            <option value="25-30 Years">25-30 Years</option>
                                                            <option value="30-35 Years">30-35 Years</option>
                                                            <option value="35-40 Years">35-40 Years</option>
                                                            <option value="40-45 Years">40-45 Years</option>
                                                            <option value="45-50 Years">45-50 Years</option>
                                                            <option value="More Then 50 Years">More Then 50 Years
                                                            </option>
                                                        </select>
                                                        @if ($errors->has('age'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('age') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-block">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="justify-content: center;">
                <div class="col-xl-6">
                    <div class="card h-auto">
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                                class="nav-link active show">About Me</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <div id="about-me" class="tab-pane fade active show">
                                            <div class="profile-about-me">
                                                <div class="pt-4 border-bottom-1 pb-3">
                                                    <h4 class="text-primary">About Me</h4>
                                                    <p class="mb-2">{{ Auth::user()->about_me ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            @if (!empty($skills))
                                                <div class="profile-skills mb-5">
                                                    <h4 class="text-primary mb-2">Skills</h4>
                                                    @foreach ($skills as $skill)
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-primary light btn-xs mb-1">{{ $skill->name ?? 'N/A' }}</a>
                                                    @endforeach

                                                </div>
                                            @endif
                                            @if (!empty($languageUser))
                                                <div class="profile-lang  mb-5">
                                                    <h4 class="text-primary mb-2">Language</h4>
                                                    @foreach ($languageUser as $languageUser)
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-primary light btn-xs mb-1">{{ $languageUser->name ?? 'N/A' }}</a>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="profile-personal-info">
                                                <h4 class="text-primary mb-4">Personal Information</h4>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Name <span class="pull-end">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->first_name }}
                                                            {{ Auth::user()->last_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->email }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Availability <span
                                                                class="pull-end">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">
                                                        <span>{{ Auth::user()->availability }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Age <span class="pull-end">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->age }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Location <span class="pull-end">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">
                                                        <span>{{ Auth::user()->location }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Experience <span class="pull-end">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">
                                                        <span>{{ Auth::user()->experience }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="replyModal">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Post Reply</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <textarea class="form-control" rows="4">Message</textarea>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary btn-sm">Reply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="footer">
                <div class="copyright">
                    <p>Copyright © Designed &amp; Developed by <a href="https:// Cybinix.com/" target="_blank">
                            Cybinix</a> 2022</p>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Person</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="PersonName" class="form-label d-block">Enter Name</label>
                        <input type="text" id="PersonName" class="form-control w-100 mb-3" placeholder="Username">
                        <label for="PersonPosition" class="form-label d-block">Enter Position</label>
                        <input type="text" id="PersonPosition" class="form-control w-100" placeholder="Position">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
