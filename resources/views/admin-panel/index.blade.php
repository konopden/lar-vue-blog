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
    <link rel="stylesheet" href="{{ mix('css/admin-panel.css') }}">
    <link rel="shortcut icon" href="public/favicon.ico">
    <script>
        window.User = {!! Auth::user() !!};
        window.Language = '{{ config('app.locale') }}';
    </script>
</head>
<body>
<div id="app">
</div>
<script src="{{ mix("js/admin-panel.js") }}"></script>
</body>
</html>
