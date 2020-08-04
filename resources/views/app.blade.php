<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Useful Blog</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="public/favicon.ico">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @if (!Auth::guest() && Auth::user()->is_admin)
        <link rel="stylesheet" href="{{ mix('css/admin-header.css') }}">
    @endif
    <script>
        window.Language = '{{ config('app.locale') }}';
    </script>
</head>
<body>
<div id="app">
    <loader></loader>
    @if (!Auth::guest() && Auth::user()->is_admin)
        <div id="admin-panel">
            <a href="/{{app()->getLocale()}}/admin-panel/home">
                <i data-v-46d5cfea="" class="fas fa-user-cog"></i> Admin panel
            </a>
        </div>
    @endif
    @include('partials.left_side')
    <div id="colorlib-main">
        @yield('content')
    </div>
</div>
<script src="{{ mix("js/app.js") }}"></script>
@yield('scripts')
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00"/>
    </svg>
</div>
</body>
</html>
