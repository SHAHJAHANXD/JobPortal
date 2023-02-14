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
    <title>Cybinix Job Portal | Verify Email</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
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
                                    <img src="{{ asset('dashboard') }}/images/verify.png" class="education-img">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="sign-in-your">
                                    <h3>Verify your account</h3>
                                    <form action="{{ route('verify.postverify') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Code</strong></label>
                                            <input type="integer" class="form-control" placeholder="Enter 6 digit code"
                                                name="code">
                                            @if ($errors->has('code'))
                                                <span class="text-danger">{{ $errors->first('code') }}</span>
                                            @endif
                                        </div>
                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            <div class="mb-3">
                                                <a href="{{ route('resend.code') }}">Resend Code?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Verify</button>
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
