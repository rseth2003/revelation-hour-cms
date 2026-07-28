@extends('layouts.app')

@section('title', 'Revelation Hour Ministries International')
@section('description', 'Worship, grow and belong at Revelation Hour Ministries International in Nakwero–Gayaza, Uganda.')

@section('content')
@include('partials.home-hero-slider')

<section class="section home-praise-reports"><div class="container"><div class="section-heading-row"><div><p class="eyebrow">See What God Is Doing</p><h2>Praise Reports</h2><p>Stories of answered prayer, restoration and lives transformed in our church community.</p></div><a class="text-link" href="{{ route('praise-reports.index') }}">View all praise reports →</a></div><div class="pr-grid pr-home-grid">@forelse($homepagePraiseReports as $report)<article class="pr-card">@if($report->photo_url)<img src="{{ $report->photo_url }}" alt="{{ $report->person_name ?: $report->title }}">@else<div class="pr-card-placeholder">🙌</div>@endif<div class="pr-card-body">@if($report->category)<span class="pr-chip">{{ $report->category }}</span>@endif<h3>{{ $report->title }}</h3>@if($report->person_name)<p class="pr-person">{{ $report->person_name }}</p>@endif<p>{{ $report->summary ?: \Illuminate\Support\Str::limit(strip_tags($report->testimony),150) }}</p><a class="text-link" href="{{ route('praise-reports.show',$report) }}">Read testimony →</a></div></article>@empty<div class="pr-empty-home"><h3>Praise reports will appear here</h3><p>Approved testimonies shared by the church will help new visitors see what God is doing.</p></div>@endforelse</div></div></section>

<section class="quick-actions" aria-label="Quick links">
    <div class="container quick-grid">
        <a href="#services"><span>01</span><strong>Service Times</strong><small>Join a weekly gathering</small></a>
        <a href="{{ route('events') }}"><span>02</span><strong>Upcoming Events</strong><small>See what is happening</small></a>
        <a href="{{ route('ministries') }}"><span>03</span><strong>Find Community</strong><small>Grow and serve with others</small></a>
        <a href="{{ route('give') }}"><span>04</span><strong>Give</strong><small>Partner with the ministry</small></a>
    </div>
</section>

<section class="section home-welcome" aria-labelledby="welcome-heading">
    <div class="container home-welcome-grid">
        <div class="home-welcome-copy">
            <p class="eyebrow">Welcome Home</p>
            <h2 id="welcome-heading">A church where faith grows and lives are transformed</h2>
            <p>Revelation Hour Ministries International is a Christ-centred community devoted to worship, prayer, biblical teaching and raising people who live with purpose.</p>
            <p>Whether you are visiting for the first time, joining online or looking for a church family, there is a place for you here.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="{{ route('visit') }}">Plan Your Visit</a>
                <a class="btn btn-dark-outline" href="{{ route('about') }}">Discover Our Story</a>
            </div>
        </div>
        <div class="home-welcome-panel" aria-label="Revelation Hour Ministries International">
            <img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="Revelation Hour Ministries International logo">
            <div>
                <span>Worship</span><span>Word</span><span>Prayer</span><span>Community</span>
            </div>
        </div>
    </div>
</section>

<section class="section section-soft" id="services">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Join Us This Week</p>
            <h2>Weekly Service Schedule</h2>
            <p>Come for worship, biblical teaching, prayer and fellowship.</p>
        </div>

        <div class="service-grid home-service-grid">
            <article class="card home-service-card"><span>Tuesday</span><h3>Bible Study Service</h3><p>6:00 PM – 8:00 PM</p></article>
            <article class="card home-service-card"><span>Thursday</span><h3>MCS</h3><p>7:30 PM</p></article>
            <article class="card home-service-card"><span>Friday</span><h3>Camp Meeting</h3><p>6:00 PM – 10:00 PM</p></article>
            <article class="card home-service-card"><span>Sunday</span><h3>Business Service</h3><p>9:00 AM – 11:00 AM</p></article>
            <article class="card home-service-card"><span>Sunday</span><h3>Sunday Service</h3><p>11:00 AM – 1:00 PM</p></article>
        </div>
        <div class="center-action"><a class="text-link" href="{{ route('service-times') }}">View full service details →</a></div>
    </div>
</section>

@include('partials.home-livestream')

<section class="section section-blue home-ministries-section">
    <div class="container">
        <div class="section-heading light">
            <p class="eyebrow">Find Your Community</p>
            <h2>A place for every generation</h2>
            <p>Connect, grow and serve through a ministry that fits your season of life.</p>
        </div>

        @if($ministries->isEmpty())
            <div class="empty-state light-empty">Ministry information will be published soon.</div>
        @else
            <div class="ministry-image-grid">
                @foreach($ministries as $ministry)
                    <a class="ministry-image-card" href="{{ route('ministries.show', $ministry) }}">
                        @if($ministry->cover_image_url)
                            <img src="{{ $ministry->cover_image_url }}" alt="{{ $ministry->name }}" class="ministry-home-photo">
                        @else
                            <div class="ministry-photo"><span>{{ $ministry->name }}</span></div>
                        @endif
                        <div class="ministry-card-copy">
                            <h3>{{ $ministry->name }}</h3>
                            @if($ministry->short_description)<p>{{ $ministry->short_description }}</p>@endif
                            <strong>Explore ministry →</strong>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="center-action"><a class="btn btn-outline" href="{{ route('ministries') }}">View All Ministries</a></div>
        @endif
    </div>
</section>

<section class="section home-events-section">
    <div class="container">
        <div class="section-heading section-heading-row">
            <div>
                <p class="eyebrow">What Is Happening</p>
                <h2>Upcoming Events</h2>
                <p>Gather with us for worship, fellowship and special ministry moments.</p>
            </div>
            <a class="text-link" href="{{ route('events') }}">View all events →</a>
        </div>

        <div class="event-carousel" data-event-carousel>
            <button class="carousel-control previous" type="button" aria-label="Previous event" data-carousel-previous>‹</button>
            <div class="event-track" data-event-track>
                @forelse($events as $event)
                    <article class="event-slide {{ $loop->first ? 'active' : '' }}">
                        @if($event->poster_url)
                            <img src="{{ $event->poster_url }}" alt="{{ $event->title }}">
                        @else
                            <div class="event-placeholder"><span>{{ $event->title }}</span></div>
                        @endif
                        <div class="event-caption">
                            <strong>{{ $event->title }}</strong>
                            <span>
                                @if($event->event_date){{ $event->event_date->format('D, j M Y') }}@endif
                                @if($event->location) · {{ $event->location }}@endif
                            </span>
                        </div>
                    </article>
                @empty
                    <article class="event-slide active">
                        <div class="event-placeholder"><span>Upcoming event details will be published here.</span></div>
                    </article>
                @endforelse
            </div>
            <button class="carousel-control next" type="button" aria-label="Next event" data-carousel-next>›</button>
        </div>
        <div class="carousel-dots" data-carousel-dots></div>
    </div>
</section>

<section class="section section-soft sermon-section">
    <div class="container sermon-grid home-sermon-grid">
        <div class="sermon-media">
            @if($featuredSermon && $featuredSermon->thumbnail_url)
                <img src="{{ $featuredSermon->thumbnail_url }}" alt="{{ $featuredSermon->title }}" class="homepage-sermon-image">
            @else
                <div class="play-mark">▶</div><p>Latest message</p>
            @endif
        </div>
        <div class="home-sermon-copy">
            <p class="eyebrow">Grow Through the Word</p>
            <h2>{{ $featuredSermon?->title ?? 'Watch the latest sermon' }}</h2>
            @if($featuredSermon?->speaker)<p class="sermon-speaker">Speaker: {{ $featuredSermon->speaker }}</p>@endif
            <p>{{ $featuredSermon?->description ?: 'Explore sermons, worship experiences and ministry messages from Revelation Hour Ministries International.' }}</p>
            <div class="hero-actions">
                @if($featuredSermon?->youtube_url)
                    <a class="btn btn-primary" href="{{ $featuredSermon->youtube_url }}" target="_blank" rel="noopener">Watch Sermon</a>
                @else
                    <a class="btn btn-primary" href="https://youtube.com/@revelationhourm?si=gyH5QweTg4264hK-" target="_blank" rel="noopener">Visit YouTube</a>
                @endif
                <a class="btn btn-dark-outline" href="{{ route('sermons') }}">Browse Messages</a>
            </div>
        </div>
    </div>
</section>



@include('partials.home-daily-word')

<section class="section home-final-cta">
    <div class="container home-final-cta-inner">
        <div>
            <p class="eyebrow">Take Your Next Step</p>
            <h2>Visit, connect or partner with RHMI</h2>
            <p>We would be honoured to welcome you, pray with you and help you find your place in the church community.</p>
        </div>
        <div class="home-final-actions">
            <a class="btn btn-primary" href="{{ route('visit') }}">Plan Your Visit</a>
            <a class="btn btn-outline" href="{{ route('contact') }}">Contact & Prayer</a>
            <a class="btn btn-outline" href="{{ route('give') }}">Give</a>
        </div>
    </div>
</section>
@endsection
