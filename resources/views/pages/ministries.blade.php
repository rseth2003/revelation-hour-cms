@extends('layouts.app')

@section('title', 'Ministries | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Find Your Place</p>
        <h1>Ministries for every generation</h1>
        <p>Grow in faith, build community and use your gifts.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        @if($ministries->isEmpty())
            <div class="empty-state">No ministries have been published yet.</div>
        @else
            <div class="ministry-page-grid">
                @foreach($ministries as $ministry)
                    <a class="ministry-page-card" href="{{ route('ministries.show', $ministry) }}">
                        @if($ministry->cover_image_url)
                            <img src="{{ $ministry->cover_image_url }}" alt="{{ $ministry->name }}" class="ministry-page-photo">
                        @else
                            <div class="ministry-page-image"><span>{{ $ministry->name }}</span></div>
                        @endif

                        <div class="ministry-page-copy">
                            <h2>{{ $ministry->name }}</h2>
                            <p>{{ $ministry->short_description }}</p>
                            <strong>View ministry</strong>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
