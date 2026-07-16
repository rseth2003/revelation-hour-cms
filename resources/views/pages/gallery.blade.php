@extends('layouts.app')

@section('title', 'Gallery | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Life at Revelation Hour</p>
        <h1>Church gallery</h1>
        <p>Explore worship services, conferences, outreach, ministry gatherings and special moments.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        @if($albums->isEmpty())
            <div class="empty-state">No gallery albums have been published yet.</div>
        @else
            <div class="public-gallery-grid">
                @foreach($albums as $album)
                    <a class="public-gallery-card" href="{{ route('gallery.show', $album) }}">
                        @if($album->cover_image_url)
                            <img src="{{ $album->cover_image_url }}" alt="{{ $album->title }}">
                        @else
                            <div class="public-gallery-placeholder">{{ $album->title }}</div>
                        @endif

                        <div class="public-gallery-copy">
                            @if($album->is_featured)
                                <span class="gallery-featured-label">Featured Album</span>
                            @endif

                            <h2>{{ $album->title }}</h2>

                            @if($album->album_date)
                                <p class="event-date">{{ $album->album_date->format('j M Y') }}</p>
                            @endif

                            <p>{{ \Illuminate\Support\Str::limit($album->description, 140) }}</p>
                            <strong>{{ $album->images_count }} photos</strong>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
