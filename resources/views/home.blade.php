@extends('layouts.app')
@section('title', 'Revelation Hour Ministries International')
@section('content')
<section class="hero"><div class="hero-overlay"></div><div class="container hero-content">
<p class="eyebrow">Word | Worth | Wonder</p>
<h1>Welcome to Revelation Hour Ministries International</h1>
<p class="hero-copy">Encounter God, grow through His Word, belong to a caring community and live with purpose.</p>
<div class="hero-actions"><a class="btn btn-primary" href="{{ route('visit') }}">Plan Your Visit</a><a class="btn btn-outline" href="https://youtube.com/@revelationhourm?si=gyH5QweTg4264hK-" target="_blank" rel="noopener">Watch Online</a></div>
</div></section>

<section class="quick-actions"><div class="container quick-grid">
<a href="#services"><span>01</span><strong>Service Times</strong><small>Find your next gathering</small></a>
<a href="{{ route('events') }}"><span>02</span><strong>Upcoming Events</strong><small>See what is happening</small></a>
<a href="{{ route('ministries') }}"><span>03</span><strong>Find Community</strong><small>Grow and serve with others</small></a>
<a href="{{ route('give') }}"><span>04</span><strong>Give & Partner</strong><small>Support the work of ministry</small></a>
</div></section>

<section class="section" id="services"><div class="container"><div class="section-heading"><p class="eyebrow">Join Us This Week</p><h2>Weekly Service Schedule</h2><p>Worship, biblical teaching, prayer and fellowship.</p></div>
<div class="service-grid">
<article class="card"><span>Tuesday</span><h3>Bible Study Service</h3><p>6:00 PM - 8:00 PM</p></article>
<article class="card"><span>Thursday</span><h3>MCS</h3><p>7:30 PM</p></article>
<article class="card"><span>Friday</span><h3>Camp Meeting</h3><p>6:00 PM - 10:00 PM</p></article>
<article class="card"><span>Sunday</span><h3>Business Service</h3><p>9:00 AM - 11:00 AM</p></article>
<article class="card"><span>Sunday</span><h3>Sunday Service</h3><p>11:00 AM - 1:00 PM</p></article>
</div></div></section>

<section class="section section-soft"><div class="container split-feature">
<div class="pastor-placeholder"><img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="RHMI"><span>Pastor portrait and official welcome will be added through the CMS.</span></div>
<div><p class="eyebrow">Welcome to Our Family</p><h2 class="section-title-left">A place to know Christ and grow together</h2><p>Whether you are searching, growing or ready to serve, there is a place for you at Revelation Hour Ministries International.</p><div class="hero-actions"><a class="btn btn-primary" href="{{ route('about') }}">Discover Our Story</a><a class="btn btn-dark-outline" href="{{ route('contact') }}">Connect With Us</a></div></div>
</div></section>

<section class="section section-blue"><div class="container"><div class="section-heading light"><p class="eyebrow">Featured Ministries</p><h2>A place for every generation</h2><p>Ministry pictures and updates will later be managed from the CMS.</p></div>
<div class="ministry-image-grid">@foreach($ministries as $ministry)<a class="ministry-image-card" href="{{ route('ministries.show', $ministry['slug']) }}"><div class="ministry-photo"><span>{{ $ministry['short'] }}</span></div><div class="ministry-card-copy"><h3>{{ $ministry['name'] }}</h3><p>{{ $ministry['summary'] }}</p><strong>Explore ministry →</strong></div></a>@endforeach</div>
<div class="center-action"><a class="btn btn-primary" href="{{ route('ministries') }}">View All Ministries</a></div></div></section>

<section class="section section-soft"><div class="container"><div class="section-heading"><p class="eyebrow">What Is Happening</p><h2>Upcoming Events</h2><p>Published events from the CMS appear automatically.</p></div>
<div class="event-carousel" data-event-carousel><button class="carousel-control previous" data-carousel-previous>‹</button><div class="event-track" data-event-track>
@forelse($events as $event)<article class="event-slide {{ $loop->first ? 'active' : '' }}">@if($event->poster_url)<img src="{{ $event->poster_url }}" alt="{{ $event->title }}">@else<div class="event-placeholder"><span>{{ $event->title }}</span></div>@endif<div class="event-caption"><strong>{{ $event->title }}</strong><span>@if($event->event_date){{ $event->event_date->format('D, j M Y') }}@endif @if($event->location) | {{ $event->location }}@endif</span></div></article>
@empty<article class="event-slide active"><img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="RHMI"><div class="event-caption"><strong>Welcome to Revelation Hour</strong><span>New events will appear here.</span></div></article>@endforelse
</div><button class="carousel-control next" data-carousel-next>›</button></div><div class="carousel-dots" data-carousel-dots></div><div class="center-action"><a class="btn btn-dark-outline" href="{{ route('events') }}">View All Events</a></div>
</div></section>

<section class="section sermon-section"><div class="container sermon-grid"><div class="sermon-media"><div class="play-mark">▶</div><p>Latest message</p></div><div><p class="eyebrow">Grow Through the Word</p><h2>Watch the latest sermon</h2><p>Explore sermons, worship experiences and ministry messages.</p><div class="hero-actions"><a class="btn btn-primary" href="https://youtube.com/@revelationhourm?si=gyH5QweTg4264hK-" target="_blank" rel="noopener">Visit YouTube</a><a class="btn btn-dark-outline" href="{{ route('sermons') }}">Browse Messages</a></div></div></div></section>

<section class="section section-soft"><div class="container two-column word-section"><div><p class="eyebrow">Daily Encouragement</p><h2>Word of the Day</h2><p>Receive scripture, devotion, posters and audio messages.</p><p class="scripture">“Your word is a lamp to my feet and a light to my path.” - Psalm 119:105</p></div><div class="upload-preview"><div class="preview-icon">✦</div><h3>Fresh encouragement every day</h3><p>Content will be published securely from the CMS.</p></div></div></section>

<section class="section involvement"><div class="container"><div class="section-heading"><p class="eyebrow">Take Your Next Step</p><h2>Grow, belong and make an impact</h2></div><div class="involvement-grid">
<article><span>01</span><h3>Follow Jesus</h3><p>Learn our beliefs and grow in your relationship with Christ.</p><a href="{{ route('about') }}#beliefs">Explore our beliefs →</a></article>
<article><span>02</span><h3>Join Community</h3><p>Build meaningful relationships through ministries and fellowship.</p><a href="{{ route('ministries') }}">Find community →</a></article>
<article><span>03</span><h3>Serve Others</h3><p>Use your gifts to make a difference in church and community.</p><a href="{{ route('contact') }}">Start serving →</a></article>
</div></div></section>

<section class="section giving-section"><div class="container giving-inner"><div><p class="eyebrow">Generosity Changes Lives</p><h2>Partner with the work of God</h2><p>Your giving supports ministry, outreach, discipleship and the Gospel.</p></div><a class="btn btn-primary" href="{{ route('give') }}">View Giving Information</a></div></section>
@endsection
