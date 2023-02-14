<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Cybinix Job Portal">
    <meta name="author" content="Cybinix Job Portal">
    <meta name="robots" content="Cybinix Job Portal">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cybinix Job Portal">
    <meta property="og:title" content="Cybinix Job Portal">
    <meta property="og:description" content="Cybinix Job Portal">
    <meta property="og:image" content="{{ asset('dashboard') }}/social-image.png">
    <meta name="format-detection" content="telephone=no">
    <title>Cybinix Job Portal | Complete Profile</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('dashboard') }}/images/favicon.png">
    <link href="{{ asset('dashboard') }}/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="{{ asset('dashboard') }}/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <link href="{{ asset('dashboard') }}/css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body class="body  h-100">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-contain-center">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body ">
                        <div class="row m-0">
                            <div class="col-xl-6 col-md-6 sign text-center">
                                <div>
                                    <div class="text-center my-5">
                                        <div class="logo" style="justify-content: center;">
                                            <svg class="logo-abbr" width="43" height="34" viewBox="0 0 43 34"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="22.6154" width="19.6154" height="6.53846" rx="3.26923"
                                                    fill="white" />
                                                <rect x="22.6154" y="9.15387" width="19.6154" height="6.53846"
                                                    rx="3.26923" fill="white" />
                                                <rect x="22.6154" y="18.3077" width="19.6154" height="6.53846"
                                                    rx="3.26923" fill="white" />
                                                <rect x="0.384583" y="18.3077" width="19.6154" height="6.53846"
                                                    rx="3.26923" fill="white" />
                                                <rect x="22.6154" y="27.4615" width="19.6154" height="6.53846"
                                                    rx="3.26923" fill="white" />
                                                <rect x="0.384583" y="27.4615" width="19.6154" height="6.53846"
                                                    rx="3.26923" fill="white" />
                                            </svg>
                                            <h2 style="margin-left: 10px;">Cybinix Job Portal</h2>
                                        </div>
                                    </div>
                                    <img src="{{ asset('dashboard') }}/images/profile.png" class="education-img">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6" style="margin-top: auto; margin-bottom: auto">
                                <div class="sign-in-your">
                                    <h3>Complete Your Profile</h3>
                                    <form action="{{ route('candidate.postcompleteprofile') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>About me</strong></label>
                                            <textarea class="form-control" name="about_me">Your Biography</textarea>
                                            @if ($errors->has('about_me'))
                                                <span class="text-danger">{{ $errors->first('about_me') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Skills</strong></label>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="HTML"
                                                        name="skills[]"> HTML
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="CSS"
                                                        name="skills[]"> CSS
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="BOOTSTRAP"
                                                        name="skills[]"> BOOTSTRAP
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="REACT JS"
                                                        name="skills[]"> REACT JS
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="VUE JS"
                                                        name="skills[]"> VUE JS
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="ANGULAR JS"
                                                        name="skills[]"> ANGULAR JS
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="NEXT JS"
                                                        name="skills[]"> NEXT JS
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="EXPRESS JS"
                                                        name="skills[]"> EXPRESS JS
                                                </div>
                                                <div class="col-lg-4">
                                                    <input  type="checkbox" class="form-check-input"
                                                        placeholder="Enter Your Skills" value="BOOTSTRAP"
                                                        name="skills[]"> BOOTSTRAP
                                                </div>
                                            </div>
                                            @if ($errors->has('skills'))
                                                <span class="text-danger">{{ $errors->first('skills') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Designation</strong></label>
                                            <input required type="text" class="form-control"
                                                placeholder="Enter Your Designation/Expertise" name="designation">
                                            @if ($errors->has('designation'))
                                                <span class="text-danger">{{ $errors->first('designation') }}</span>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Experience</strong></label>
                                            <select required name="experience" id="" class="form-control"
                                                style="background: #2A2A2A">
                                                <option value="">Select</option>
                                                <option value="Less Then 1 Years">Less Then 1 Years</option>
                                                <option value="1-2 Years">1-2 Years</option>
                                                <option value="2-3 Years">2-3 Years</option>
                                                <option value="3-4 Years">3-4 Years</option>
                                                <option value="4-5 Years">4-5 Years</option>
                                                <option value="5-6 Years">5-6 Years</option>
                                                <option value="6-7 Years">6-7 Years</option>
                                                <option value="7-8 Years">7-8 Years</option>
                                                <option value="8-9 Years">8-9 Years</option>
                                                <option value="9-10 Years">9-10 Years</option>
                                                <option value="More Then 10 Years">More Then 10 Years</option>
                                            </select>
                                            @if ($errors->has('experience'))
                                                <span class="text-danger">{{ $errors->first('experience') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Availability</strong></label>
                                            <select required name="availability" id="" class="form-control"
                                                style="background: #2A2A2A">
                                                <option value="">Select</option>
                                                <option value="1-2 Hours">1-2 Hours</option>
                                                <option value="3-4 Hours">3-4 Hours</option>
                                                <option value="5-6 Hours">5-6 Hours</option>
                                                <option value="7-8 Hours">7-8 Hours</option>
                                                <option value="9-10 Hours">9-10 Hours</option>
                                            </select>
                                            @if ($errors->has('availability'))
                                                <span class="text-danger">{{ $errors->first('availability') }}</span>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Age</strong></label>
                                            <select required name="age" id="" class="form-control"
                                                style="background: #2A2A2A">
                                                <option value="">Select</option>
                                                <option value="Less Then 15 Years">Less Then 15 Years</option>
                                                <option value="15-20 Years">15-20 Years</option>
                                                <option value="20-25 Years">20-25 Years</option>
                                                <option value="25-30 Years">25-30 Years</option>
                                                <option value="30-35 Years">30-35 Years</option>
                                                <option value="35-40 Years">35-40 Years</option>
                                                <option value="40-45 Years">40-45 Years</option>
                                                <option value="45-50 Years">45-50 Years</option>
                                                <option value="More Then 50 Years">More Then 50 Years</option>
                                            </select>
                                            @if ($errors->has('age'))
                                                <span class="text-danger">{{ $errors->first('age') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Location</strong></label>
                                            <input required type="text" class="form-control"
                                                placeholder="Enter Your Address/Location" name="location">
                                            @if ($errors->has('location'))
                                                <span class="text-danger">{{ $errors->first('location') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Language</strong></label>
                                            <input required type="text" class="form-control"
                                                placeholder="Enter Your Native Languages You Speak" name="language">
                                            @if ($errors->has('language'))
                                                <span class="text-danger">{{ $errors->first('language') }}</span>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                        <div class="new-account mt-3">
                                            <p class="text-white">Want to logout? <a class="text-primary"
                                                    href="{{ route('Logout') }}">Logout</a></p>
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

    <script src="{{ asset('dashboard') }}/vendor/global/global.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendor/jquery-autocomplete/jquery-ui.js"></script>
    <script src="{{ asset('dashboard') }}/js/custom.min.js"></script>
    <script src="{{ asset('dashboard') }}/js/dlabnav-init.js"></script>
    <script src="{{ asset('dashboard') }}/js/styleSwitcher.js"></script>
    <script>
        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif
    </script>
    <script>
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif
    </script>
</body>

</html>
