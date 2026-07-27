<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Revelation Hour Ministries International')</title>
    <meta name="description" content="@yield('description', 'Revelation Hour Ministries International.')">
    <meta name="theme-color" content="#16005f">
    <meta name="application-name" content="RHMI">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="RHMI">
    <link rel="icon" type="image/png" sizes="64x64" href="/pwa/icons/favicon-64.png">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/pwa/icons/apple-touch-icon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.navbar')
    <main>@yield('content')</main>
    @include('partials.footer')
@include('partials.flash-toast')
    @include('partials.pwa-install')
</body>
</html>
