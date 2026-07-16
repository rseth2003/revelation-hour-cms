@php
    $site = $websiteSettings ?? \App\Models\WebsiteSetting::current();
    $siteLogo = $site->logo_url ?: asset('images/revelation-hour-logo.jpg');
@endphp

<header class="site-header">
    <nav class="navbar">
        <div class="container nav-inner">
            <a class="brand" href="{{ route('home') }}">
                <img src="{{ $siteLogo }}" alt="{{ $site->church_name }} logo">
            </a>

            <button class="nav-toggle" type="button" aria-label="Open navigation">☰</button>

            <div class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('campuses') }}">Campuses</a>
                <a href="{{ route('ministries') }}">Ministries</a>
                <a href="{{ route('events') }}">Events</a>
                <a href="{{ route('sermons') }}">Sermons</a>
                <a href="{{ route('gallery') }}">Gallery</a>
                <a href="{{ route('visit') }}">Plan Your Visit</a>
                <a href="{{ route('contact') }}">Connect</a>
                <a class="nav-give" href="{{ route('give') }}">Give</a>
            </div>
        </div>
    </nav>
</header>
