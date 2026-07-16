@extends('layouts.app')

@section('title', 'Sermons | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Media and Messages</p>
        <h1>Grow through the Word</h1>
        <p>Watch, listen and study sermons from Revelation Hour Ministries International.</p>
    </div>
</section>

@if($featured)
<section class="section">
    <div class="container sermon-public-feature">
        <div class="sermon-public-media">
            @if($featured->youtube_embed_url)
                <iframe src="{{ $featured->youtube_embed_url }}" title="{{ $featured->title }}" allowfullscreen loading="lazy"></iframe>
            @elseif($featured->thumbnail_url)
                <img src="{{ $featured->thumbnail_url }}" alt="{{ $featured->title }}">
            @else
                <div class="sermon-public-placeholder">▶</div>
            @endif
        </div>

        <div>
            <p class="eyebrow">Featured Sermon</p>
            <h2 class="section-title-left">{{ $featured->title }}</h2>

            @if($featured->speaker)
                <p><strong>Speaker:</strong> {{ $featured->speaker }}</p>
            @endif

            @if($featured->bible_passage)
                <p><strong>Scripture:</strong> {{ $featured->bible_passage }}</p>
            @endif

            @if($featured->description)
                <p>{{ $featured->description }}</p>
            @endif

            <div class="sermon-actions">
                @if($featured->youtube_url)
                    <a class="btn btn-primary" href="{{ $featured->youtube_url }}" target="_blank" rel="noopener">Watch</a>
                @endif

                @if($featured->audio_url)
                    <a class="btn btn-dark-outline" href="{{ $featured->audio_url }}" target="_blank">Listen</a>
                @endif

                @if($featured->notes_url)
                    <a class="btn btn-dark-outline" href="{{ $featured->notes_url }}" target="_blank">Download Notes</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<section class="section {{ $featured ? 'section-soft' : '' }}">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Message Library</p>
            <h2>Latest sermons</h2>
        </div>

        @if($sermons->isEmpty())
            <div class="empty-state">No sermons have been published yet.</div>
        @else
            <div class="public-sermon-grid">
                @foreach($sermons as $sermon)
                    <article class="public-sermon-card">
                        @if($sermon->thumbnail_url)
                            <img src="{{ $sermon->thumbnail_url }}" alt="{{ $sermon->title }}">
                        @else
                            <div class="sermon-card-placeholder">▶</div>
                        @endif

                        <div class="public-sermon-copy">
                            @if($sermon->sermon_date)
                                <p class="event-date">{{ $sermon->sermon_date->format('j M Y') }}</p>
                            @endif

                            <h2>{{ $sermon->title }}</h2>

                            @if($sermon->speaker)
                                <p>{{ $sermon->speaker }}</p>
                            @endif

                            @if($sermon->series)
                                <p><strong>Series:</strong> {{ $sermon->series }}</p>
                            @endif

                            <div class="sermon-card-actions">
                                @if($sermon->youtube_url)
                                    <a href="{{ $sermon->youtube_url }}" target="_blank" rel="noopener">Watch</a>
                                @endif

                                @if($sermon->audio_url)
                                    <a href="{{ $sermon->audio_url }}" target="_blank">Listen</a>
                                @endif

                                @if($sermon->notes_url)
                                    <a href="{{ $sermon->notes_url }}" target="_blank">Notes</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
