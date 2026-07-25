@extends('layouts.app')

@section('title', $livestream->title . ' | RHMI Livestream')

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">{{ strtoupper($livestream->status) }}</p>
            <h1>{{ $livestream->title }}</h1>

            @if ($livestream->subtitle)
                <p>{{ $livestream->subtitle }}</p>
            @endif
        </div>
    </section>

    <section class="section">
        <div class="container livestream-detail">
            @include('pages.livestreams._player', ['stream' => $livestream])

            <div class="livestream-copy">
                <p>
                    <strong>Platform:</strong>
                    {{ \App\Models\Livestream::PLATFORMS[$livestream->platform] ?? ucfirst($livestream->platform) }}
                </p>

                @if ($livestream->speaker)
                    <p><strong>Speaker:</strong> {{ $livestream->speaker }}</p>
                @endif

                @if ($livestream->scheduled_start)
                    <p>
                        <strong>Scheduled:</strong>
                        {{ $livestream->scheduled_start->format('l, j F Y · g:i A') }}
                    </p>
                @endif

                @if ($livestream->description)
                    <div>{!! nl2br(e($livestream->description)) !!}</div>
                @endif
            </div>
        </div>
    </section>
@endsection
