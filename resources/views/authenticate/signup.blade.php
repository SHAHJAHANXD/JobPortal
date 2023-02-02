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
    <title>Cybinix Job Portal | Signup</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="{{ asset('dashboard') }}/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="{{ asset('dashboard') }}/vendor/jquery-autocomplete/jquery-ui.css" rel="stylesheet">
    <link href="{{ asset('dashboard') }}/css/style.css" rel="stylesheet">
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters"  style="margin-top: 100px; margin-bottom: 100px;">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="{{ route('index') }}">
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
                                        </a>
                                    </div>
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form action="{{ route('post_signup') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>First Name</strong></label>
                                            <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" value="{{ old('first_name') }}">
                                            @if ($errors->has('first_name'))
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Last Name</strong></label>
                                            <input type="text" name="last_name"  class="form-control" placeholder="Enter Last Name" value="{{ old('last_name') }}">
                                            @if ($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email"  class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Role</strong></label>
                                            <select class="default-select form-control form-control-lg wide mb-3" name="role">
                                                <option class="opt-color">Candidate</option>
                                                <option class="opt-color">Employer</option>
                                            </select>
                                            @if ($errors->has('role'))
                                            <span class="text-danger">{{ $errors->first('role') }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                            @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me
                                                up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p class="text-white">Already have an account? <a class="text-primary"
                                                href="{{ route('login') }}">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/jquery-autocomplete/jquery-ui.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>
