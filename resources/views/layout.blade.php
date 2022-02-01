<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', '')</title>

        <link href="/img/favicon.ico" rel="SHORTCUT ICON" />

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

        @yield('extra-css')
    </head>


<body class="@yield('body-class', '')">
    <div class="main">
        @include('partials.nav')

        @include('partials.session-messages')

        @yield('content')

    </div>

    @include('partials.contact')

    @include('partials.footer')
    

    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('extra-js')

</body>
</html>
