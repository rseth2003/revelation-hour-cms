@extends('layouts.app')

@section('title', 'About RHMI')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">About RHMI</p>
        <h1>Revelation Hour Ministries International</h1>
        <p>Learn about our story, vision, mission, values and leadership.</p>
    </div>
</section>

<section class="section" id="story">
    <div class="container two-column">
        <div>
            <p class="eyebrow">Our Story</p>
            <h2 class="section-title-left">{{ $aboutSetting->story_heading }}</h2>
            <div class="about-rich-text">
                {!! nl2br(e($aboutSetting->story_body)) !!}
            </div>
        </div>

        <div class="story-panel">
            <img
                src="{{ asset('images/revelation-hour-logo.jpg') }}"
                alt="Revelation Hour Ministries International"
            >
        </div>
    </div>
</section>

<section class="section section-soft" id="vision-mission">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Our Direction</p>
            <h2>Vision and Mission</h2>
        </div>

        <div class="about-grid">
            <article class="about-card">
                <span class="about-number">01</span>
                <h3>{{ $aboutSetting->vision_heading }}</h3>
                <div>{!! nl2br(e($aboutSetting->vision_body)) !!}</div>
            </article>

            <article class="about-card">
                <span class="about-number">02</span>
                <h3>{{ $aboutSetting->mission_heading }}</h3>
                <div>{!! nl2br(e($aboutSetting->mission_body)) !!}</div>
            </article>

            @if (filled($aboutSetting->motto))
                <article class="about-card">
                    <span class="about-number">03</span>
                    <h3>Our Motto</h3>
                    <p class="about-motto">{{ $aboutSetting->motto }}</p>
                    <a href="{{ route('about.motto') }}" class="text-link">Read about our motto</a>
                </article>
            @endif
        </div>
    </div>
</section>

<section class="section" id="core-values">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">What Guides Us</p>
            <h2>Core Values</h2>
        </div>

        <div class="belief-grid">
            @forelse ($coreValues as $coreValue)
                <article>
                    <h3>{{ $coreValue->title }}</h3>
                    <p>{{ $coreValue->description }}</p>
                </article>
            @empty
                <div class="empty-state">
                    Core values will be published here once approved by the ministry.
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="section section-soft" id="leadership">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Leadership</p>
            <h2>Serving Christ and His people</h2>
        </div>

        <div class="leader-grid">
            @forelse ($leaders as $leader)
                <article class="leader-card">
                    @if ($leader->photo_url)
                        <img src="{{ $leader->photo_url }}" alt="{{ $leader->name }}">
                    @else
                        <div class="leader-placeholder">
                            {{ strtoupper(substr($leader->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="leader-card-body">
                        <h3>{{ $leader->name }}</h3>
                        <p class="leader-role">{{ $leader->role }}</p>

                        @if (filled($leader->department))
                            <p class="leader-department">{{ $leader->department }}</p>
                        @endif

                        @if (filled($leader->biography))
                            <p>{{ $leader->biography }}</p>
                        @endif

                        @if (
                            filled($leader->phone) ||
                            filled($leader->email) ||
                            filled($leader->facebook_url) ||
                            filled($leader->instagram_url) ||
                            filled($leader->x_url)
                        )
                            <div class="leader-contact">
                                @if (filled($leader->phone))
                                    <a href="tel:{{ preg_replace('/\s+/', '', $leader->phone) }}">Call</a>
                                @endif

                                @if (filled($leader->email))
                                    <a href="mailto:{{ $leader->email }}">Email</a>
                                @endif

                                @if (filled($leader->facebook_url))
                                    <a href="{{ $leader->facebook_url }}" target="_blank" rel="noopener">Facebook</a>
                                @endif

                                @if (filled($leader->instagram_url))
                                    <a href="{{ $leader->instagram_url }}" target="_blank" rel="noopener">Instagram</a>
                                @endif

                                @if (filled($leader->x_url))
                                    <a href="{{ $leader->x_url }}" target="_blank" rel="noopener">X</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    Leadership profiles will be published here once approved.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
