<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @include('landingpage.layouts.heads')
    @yield('extra-heads')
</head>

<body>
    @include('landingpage.layouts.header')

    @yield('content')
    @include('landingpage.layouts.scripts')
    @yield('extra-scripts')
</body>

</html>
