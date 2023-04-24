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
    <title>Cybinix Job Portal | Login</title>
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
                                    <img src="{{ asset('dashboard') }}/images/job.png" class="education-img">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6" style="margin-top: auto; margin-bottom: auto">
                                <div class="sign-in-your">
                                    <h3>Sign in your account</h3>
                                    <form action="{{ route('post_login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input required type="email" class="form-control" placeholder="Enter Email" name="email">
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input required type="password" class="form-control" placeholder="Enter Password" name="password">
                                            @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            <div class="mb-3">
                                                <a href="{{ route('forget_password') }}">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me
                                                In</button>
                                        </div>
                                        <p class="text-center" style="margin-top: 20px;">OR</p>
                                        <div class="text-center">
                                            <a href="{{ url('auth/google') }}" type="submit" class="btn btn-primary btn-block" style="    background: #363636;"><img style="height: 40px;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/706px-Google_%22G%22_Logo.svg.png" alt=""><span style="margin-left: 15px;">Signin With Google</span></a>
                                        </div>
                                        <div class="new-account mt-3">
                                            <p class="text-white">Don't have an account? <a class="text-primary"
                                                    href="{{ route('signup') }}">Signup</a></p>
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
