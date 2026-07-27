@extends('layouts.app')

@section('title', 'Plan Your Visit | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">You Are Welcome</p>
        <h1>Plan Your Visit</h1>
        <p>Find our location, choose a service and know what to expect when you worship with us.</p>
    </div>
</section>

<section class="section">
    <div class="container visit-location-grid">
        <div>
            <p class="eyebrow">Church Location</p>
            <h2 class="section-title-left">Valley Road, Canaansite Estate</h2>
            <p>Nakwero, Gayaza, Uganda</p>
            <div class="visit-actions">
                <a class="btn btn-primary" href="https://maps.app.goo.gl/4zP4RCdjQYg9PoPn6?g_st=awb" target="_blank" rel="noopener">Open in Google Maps</a>
                <a class="btn btn-outline" href="tel:{{ preg_replace('/\s+/', '', $websiteSettings->phone_primary ?: '+256 774 328 127') }}">Call for Directions</a>
            </div>
        </div>
        <div class="visit-map-frame">
            <iframe title="RHMI location" src="https://www.google.com/maps?q=Valley+Road,+Canaansite+Estate,+Nakwero,+Gayaza,+Uganda&output=embed" loading="lazy" allowfullscreen></iframe>
        </div>
    </div>
</section>

<section class="section section-soft">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Weekly Schedule</p>
            <h2>Choose a service to attend</h2>
        </div>
        <div class="service-schedule-grid">
            @forelse($serviceTimes as $service)
                <article class="service-schedule-card">
                    <p class="service-day">{{ $service->day }}</p>
                    <h3>{{ $service->name }}</h3>
                    <p class="service-time-range">{{ $service->time_range }}</p>
                    @if($service->description)<p>{{ $service->description }}</p>@endif
                </article>
            @empty
                <div class="empty-state">The weekly service schedule will be published here.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">What to Expect</p>
            <h2>Your first visit made simple</h2>
        </div>
        <div class="visit-expect-grid">
            <article><h3>A Warm Welcome</h3><p>Our ushers will welcome you and help you find your way.</p></article>
            <article><h3>Worship and Teaching</h3><p>Expect heartfelt worship, prayer and biblical preaching.</p></article>
            <article><h3>Come as You Are</h3><p>Wear clothing that is comfortable and appropriate for worship.</p></article>
            <article><h3>Families Are Welcome</h3><p>Children, families and first-time visitors are welcome.</p></article>
        </div>
    </div>
</section>
@endsection
