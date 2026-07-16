@extends('layouts.app')

@section('title', $album->title.' | RHMI Gallery')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">RHMI Gallery</p>
        <h1>{{ $album->title }}</h1>

        @if($album->album_date)
            <p>{{ $album->album_date->format('j F Y') }}</p>
        @endif
    </div>
</section>

<section class="section">
    <div class="container">
        @if($album->description)
            <div class="gallery-album-intro">{{ $album->description }}</div>
        @endif

        @if($album->images->isEmpty())
            <div class="empty-state">No photos have been published in this album yet.</div>
        @else
            <div class="gallery-photo-grid" data-gallery-grid>
                @foreach($album->images as $image)
                    <button type="button"
                            class="gallery-photo"
                            data-gallery-image="{{ $image->image_url }}"
                            data-gallery-caption="{{ $image->caption }}">
                        <img src="{{ $image->image_url }}" alt="{{ $image->caption ?: $album->title }}" loading="lazy">
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</section>

<div class="gallery-lightbox" data-gallery-lightbox hidden>
    <button class="gallery-lightbox-close" type="button" aria-label="Close gallery">×</button>
    <button class="gallery-lightbox-arrow previous" type="button" aria-label="Previous photo">‹</button>
    <figure>
        <img src="" alt="" data-gallery-lightbox-image>
        <figcaption data-gallery-lightbox-caption></figcaption>
    </figure>
    <button class="gallery-lightbox-arrow next" type="button" aria-label="Next photo">›</button>
</div>
@endsection
