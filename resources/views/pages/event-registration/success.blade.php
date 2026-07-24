@extends('layouts.app')

@section('title', 'Registration Received | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Registration Received</p>
        <h1>Thank you, {{ $registration->full_name }}</h1>
        <p>Your registration for {{ $event->title }} has been received.</p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width:760px;">
        <div style="background:#fff;border:1px solid #dcfce7;border-radius:1.25rem;padding:clamp(1.25rem,4vw,2.5rem);box-shadow:0 12px 30px rgba(15,23,42,.06);">
            <div style="font-size:2.5rem;">✓</div>
            <h2 style="margin:.5rem 0;">Registration submitted</h2>
            <p>Your status is currently <strong>Pending</strong>. The RHMI team may contact you using the details you supplied.</p>

            <dl style="display:grid;grid-template-columns:max-content 1fr;gap:.6rem 1rem;margin-top:1.5rem;">
                <dt><strong>Event</strong></dt>
                <dd>{{ $event->title }}</dd>
                <dt><strong>Name</strong></dt>
                <dd>{{ $registration->full_name }}</dd>
                <dt><strong>Phone</strong></dt>
                <dd>{{ $registration->phone }}</dd>

                @if($event->event_date)
                    <dt><strong>Date</strong></dt>
                    <dd>{{ $event->event_date->format('D, j M Y • g:i A') }}</dd>
                @endif
            </dl>

            <a href="{{ route('events') }}" class="btn btn-primary" style="margin-top:1.5rem;">View Other Events</a>
        </div>
    </div>
</section>
@endsection
