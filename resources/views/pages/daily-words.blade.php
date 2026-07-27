@extends('layouts.app')

@section('title', 'Word of the Day | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Daily Encouragement</p>
        <h1>Word of the Day</h1>
        <p>Scripture, devotion and audio messages prepared to strengthen your faith.</p>
    </div>
</section>

@if($featured)
<section class="section">
    <div class="container daily-word-feature">
        <div>
            @if($featured->poster_url)
                <img src="{{ $featured->poster_url }}" class="daily-word-poster" alt="{{ $featured->title }}">
            @else
                <div class="daily-word-placeholder"><span>{{ $featured->scripture_reference ?: $featured->title }}</span></div>
            @endif
        </div>
        <div>
            <p class="eyebrow">{{ $featured->publish_date->format('j M Y') }}</p>
            <h2 class="section-title-left">{{ $featured->title }}</h2>
            @if($featured->scripture_reference)<p class="daily-reference">{{ $featured->scripture_reference }}</p>@endif
            @if($featured->scripture_text)<blockquote>{{ $featured->scripture_text }}</blockquote>@endif
            @if($featured->message)<div class="rich-copy">{!! nl2br(e($featured->message)) !!}</div>@endif
            @if($featured->audio_url)
                <audio controls class="daily-audio"><source src="{{ $featured->audio_url }}"></audio>
            @endif
        </div>
    </div>
</section>
@endif

<section class="section section-soft">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Archive</p>
            <h2>Previous daily messages</h2>
        </div>
        @if($words->isEmpty())
            <div class="empty-state">Previous messages will be published here.</div>
        @else
            <div class="daily-word-grid">
                @foreach($words as $word)
                    <article class="daily-word-card">
                        @if($word->poster_url)
                            <img src="{{ $word->poster_url }}" alt="{{ $word->title }}">
                        @else
                            <div class="daily-card-placeholder">{{ $word->scripture_reference ?: $word->title }}</div>
                        @endif
                        <div class="daily-word-copy">
                            <p class="event-date">{{ $word->publish_date->format('j M Y') }}</p>
                            <h2>{{ $word->title }}</h2>
                            @if($word->message)<p>{{ \Illuminate\Support\Str::limit($word->message, 150) }}</p>@endif
                            @if($word->audio_url)<audio controls><source src="{{ $word->audio_url }}"></audio>@endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
