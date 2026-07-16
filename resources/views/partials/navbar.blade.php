<header class="site-header">
<nav class="navbar" aria-label="Primary navigation">
<div class="container nav-inner">
<a class="brand" href="{{ route('home') }}"><img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="RHMI logo"></a>
<button class="nav-toggle" type="button" aria-label="Open navigation" aria-expanded="false">☰</button>
<div class="nav-links">
<a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
<a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
<a href="{{ route('ministries') }}" class="{{ request()->routeIs('ministries*') ? 'active' : '' }}">Ministries</a>
<a href="{{ route('events') }}" class="{{ request()->routeIs('events') ? 'active' : '' }}">Events</a>
<a href="{{ route('sermons') }}" class="{{ request()->routeIs('sermons') ? 'active' : '' }}">Sermons</a>
<a href="{{ route('visit') }}" class="{{ request()->routeIs('visit') ? 'active' : '' }}">Plan Your Visit</a>
<a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Connect</a>
<a class="nav-give" href="{{ route('give') }}">Give</a>
</div>
</div>
</nav>
</header>
