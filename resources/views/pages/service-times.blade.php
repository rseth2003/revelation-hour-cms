@extends('layouts.app')

@section('title', 'Service Times | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Worship With Us</p>
        <h1>Service Times</h1>
        <p>Join us for worship, prayer, biblical teaching and fellowship throughout the week.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Weekly Schedule</p>
            <h2>Find a service that works for you</h2>
        </div>

        <div class="service-schedule-grid">
            @forelse($serviceTimes as $service)
                <article class="service-schedule-card">
                    <p class="service-day">{{ $service->day }}</p>
                    <h2>{{ $service->name }}</h2>
                    <p class="service-time-range">{{ $service->time_range }}</p>
                    @if($service->description)
                        <p>{{ $service->description }}</p>
                    @endif
                </article>
            @empty
                <div class="empty-state">The weekly service schedule will be published here.</div>
            @endforelse
        </div>

        <div class="center-actions">
            <a href="{{ route('visit') }}" class="btn btn-primary">Plan Your Visit</a>
        </div>
    </div>
</section>
@endsection
