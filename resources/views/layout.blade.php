<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    @include('layouts.heads')
    @yield('extra-heads')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
    <div id="preloader">
        <div class="inner">
            <span>Loading... </span>
            <div class="loading">
            </div>
        </div>
    </div>
    <div id="main-wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')
        @yield('content')
    </div>
    @include('layouts.scripts')
    @yield('extra-scripts')
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
