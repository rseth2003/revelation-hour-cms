@extends('layouts.app')

@section('title', $ministry->name.' | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">RHMI Ministry</p>
        <h1>{{ $ministry->name }}</h1>
        <p>{{ $ministry->short_description }}</p>
    </div>
</section>

<section class="section">
    <div class="container ministry-detail-grid">
        <div>
            @if($ministry->cover_image_url)
                <img src="{{ $ministry->cover_image_url }}" alt="{{ $ministry->name }}" class="ministry-detail-photo">
            @else
                <div class="ministry-detail-visual"><span>{{ $ministry->name }}</span></div>
            @endif
        </div>

        <div>
            <p class="eyebrow">About This Ministry</p>
            <h2 class="section-title-left">Grow, belong and serve</h2>
            <div class="rich-copy">{!! nl2br(e($ministry->description)) !!}</div>

            <dl class="detail-list">
                @if($ministry->leader_name)
                    <div><dt>Ministry leader</dt><dd>{{ $ministry->leader_name }}</dd></div>
                @endif

                @if($ministry->meeting_schedule)
                    <div><dt>Meeting schedule</dt><dd>{{ $ministry->meeting_schedule }}</dd></div>
                @endif

                @if($ministry->location)
                    <div><dt>Location</dt><dd>{{ $ministry->location }}</dd></div>
                @endif

                @if($ministry->contact_phone)
                    <div><dt>Phone</dt><dd><a href="tel:{{ $ministry->contact_phone }}">{{ $ministry->contact_phone }}</a></dd></div>
                @endif

                @if($ministry->contact_email)
                    <div><dt>Email</dt><dd><a href="mailto:{{ $ministry->contact_email }}">{{ $ministry->contact_email }}</a></dd></div>
                @endif
            </dl>

            <a class="btn btn-primary" href="{{ route('contact') }}">Join This Ministry</a>
        </div>
    </div>
</section>

@if($ministry->leader_name || $ministry->leader_image_url)
<section class="section section-soft">
    <div class="container leader-feature">
        <div>
            @if($ministry->leader_image_url)
                <img src="{{ $ministry->leader_image_url }}" alt="{{ $ministry->leader_name }}" class="leader-photo">
            @endif
        </div>

        <div>
            <p class="eyebrow">Ministry Leadership</p>
            <h2 class="section-title-left">{{ $ministry->leader_name ?: 'Ministry Leader' }}</h2>
            <p>Leadership details and a full biography can be expanded in a future CMS update.</p>
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Ministry Events and Gallery</p>
            <h2>Upcoming activities</h2>
            <p>The next CMS update will add ministry galleries and ministry specific events here.</p>
        </div>

        <div class="empty-state">No ministry specific events or gallery images have been published yet.</div>
    </div>
</section>
@endsection
