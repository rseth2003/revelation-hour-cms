@extends('layouts.app')

@section('title', 'Events | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Church Calendar</p>
        <h1>Upcoming events</h1>
        <p>Worship, prayer, fellowship and outreach.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        @if ($events->isEmpty())
            <div class="empty-state">
                No published events are available yet.
            </div>
        @else
            <div class="public-events-grid">
                @foreach ($events as $event)
                    <article class="public-event-card">
                        @if ($event->poster_url)
                            <img src="{{ $event->poster_url }}" alt="{{ $event->title }}">
                        @else
                            <div class="event-card-placeholder">{{ $event->title }}</div>
                        @endif

                        <div class="public-event-copy">
                            <p class="event-date">
                                @if ($event->event_date)
                                    {{ $event->event_date->format('D, j M Y g:i A') }}
                                @else
                                    Date to be announced
                                @endif
                            </p>

                            <h2>{{ $event->title }}</h2>

                            @if ($event->location)
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                            @endif

                            @if ($event->description)
                                <p>{{ $event->description }}</p>
                            @endif

                            <a href="{{ route('event-registration.create', $event) }}" class="btn btn-primary">
                                Register
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
