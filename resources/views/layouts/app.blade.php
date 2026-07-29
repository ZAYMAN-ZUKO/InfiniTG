<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'InfiniTG')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @include('partials.sidebar')

    <div class="main">

        @include('partials.topbar')

        @yield('content')

        @include('partials.footer')

    </div>

</body>
</html>