@extends('layouts.app')

@section('title', 'Revelation Hour Ministries International')

@section('content')
@include('partials.home-hero-slider')

<section class="quick-actions">
    <div class="container quick-grid">
        <a href="#services"><span>01</span><strong>Service Times</strong><small>Find your next gathering</small></a>
        <a href="{{ route('events') }}"><span>02</span><strong>Upcoming Events</strong><small>See what is happening</small></a>
        <a href="{{ route('ministries') }}"><span>03</span><strong>Find Community</strong><small>Grow and serve with others</small></a>
        <a href="{{ route('give') }}"><span>04</span><strong>Give and Partner</strong><small>Support the work of ministry</small></a>
    </div>
</section>

<section class="section" id="services">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Join Us This Week</p>
            <h2>Weekly Service Schedule</h2>
            <p>Worship, biblical teaching, prayer and fellowship.</p>
        </div>

        <div class="service-grid">
            <article class="card"><span>Tuesday</span><h3>Bible Study Service</h3><p>6:00 PM - 8:00 PM</p></article>
            <article class="card"><span>Thursday</span><h3>MCS</h3><p>7:30 PM</p></article>
            <article class="card"><span>Friday</span><h3>Camp Meeting</h3><p>6:00 PM - 10:00 PM</p></article>
            <article class="card"><span>Sunday</span><h3>Business Service</h3><p>9:00 AM - 11:00 AM</p></article>
            <article class="card"><span>Sunday</span><h3>Sunday Service</h3><p>11:00 AM - 1:00 PM</p></article>
        </div>
    </div>
</section>

<section class="section section-blue">
    <div class="container">
        <div class="section-heading light">
            <p class="eyebrow">Featured Ministries</p>
            <h2>A place for every generation</h2>
            <p>Published ministries from the CMS appear here automatically.</p>
        </div>

        @if($ministries->isEmpty())
            <div class="empty-state light-empty">No ministries have been published yet.</div>
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
                            <p>{{ $ministry->short_description }}</p>
                            <strong>Explore ministry</strong>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="section section-soft">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">What Is Happening</p>
            <h2>Upcoming Events</h2>
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
                                @if($event->location) {{ $event->location }}@endif
                            </span>
                        </div>
                    </article>
                @empty
                    <article class="event-slide active">
                        <img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="RHMI">
                        <div class="event-caption"><strong>Welcome to Revelation Hour</strong><span>New events will appear here.</span></div>
                    </article>
                @endforelse
            </div>

            <button class="carousel-control next" type="button" aria-label="Next event" data-carousel-next>›</button>
        </div>

        <div class="carousel-dots" data-carousel-dots></div>
    </div>
</section>

<section class="section sermon-section">
    <div class="container sermon-grid">
        <div class="sermon-media">
            @if($featuredSermon && $featuredSermon->thumbnail_url)
                <img src="{{ $featuredSermon->thumbnail_url }}" alt="{{ $featuredSermon->title }}" class="homepage-sermon-image">
            @else
                <div class="play-mark">▶</div>
                <p>Latest message</p>
            @endif
        </div>

        <div>
            <p class="eyebrow">Grow Through the Word</p>
            <h2>{{ $featuredSermon?->title ?? 'Watch the latest sermon' }}</h2>

            @if($featuredSermon?->speaker)
                <p><strong>Speaker:</strong> {{ $featuredSermon->speaker }}</p>
            @endif

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
@endsection
