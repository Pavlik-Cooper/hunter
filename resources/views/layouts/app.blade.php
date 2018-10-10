<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{--<!-- Fonts -->--}}
    {{--<link href="{{ asset('css/css/all.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">
    <script>
        window.App = {!! json_encode([
            'signedIn'=> Auth::check(),
            'user'=> Auth::user()
        ]) !!};
        @if (Auth::user())
            window.user = {"name":"{{ Auth::user()->name }}","email":"{{ Auth::user()->email }}","id":"{{ Auth::user()->id }}"};
        @endif
    </script>

    <style>
        .level {
            display: flex;
            flex-direction: column;
        }
        .flex {
            display: flex;
            justify-content: space-between;
            flex-grow: 1;
        }
        [v-cloak] {
            display: none;}
    </style>
    @yield('header')
</head>
<body>
    <div id="app">
        @include('layouts.nav')
        <flash type="{{ session('flash.type') }}" message="{{ session('flash.message') }}"></flash>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
