@extends('layouts.app')

@section('title', $praiseReport->title.' | Praise Reports')
@section('description', $praiseReport->summary ?: \Illuminate\Support\Str::limit(strip_tags($praiseReport->testimony), 155))

@section('content')
<article class="section">
    <div class="container pr-detail">
        <a class="text-link" href="{{ route('praise-reports.index') }}">← All praise reports</a>

        <div class="pr-detail-grid">
            <div>
                @if($praiseReport->photo_url)
                    <img class="pr-detail-photo" src="{{ $praiseReport->photo_url }}" alt="{{ $praiseReport->person_name ?: $praiseReport->title }}">
                @endif
            </div>

            <div>
                <p class="eyebrow">Praise Report</p>
                <h1>{{ $praiseReport->title }}</h1>

                @if($praiseReport->person_name)
                    <p class="pr-person">Shared by {{ $praiseReport->person_name }}</p>
                @endif

                @if($praiseReport->testimony_date)
                    <p>{{ $praiseReport->testimony_date->format('j F Y') }}</p>
                @endif

                <div class="pr-story">{!! nl2br(e($praiseReport->testimony)) !!}</div>

                @if($praiseReport->scripture_reference || $praiseReport->scripture_text)
                    <blockquote>
                        @if($praiseReport->scripture_reference)
                            <strong>{{ $praiseReport->scripture_reference }}</strong>
                        @endif
                        @if($praiseReport->scripture_text)
                            <p>{{ $praiseReport->scripture_text }}</p>
                        @endif
                    </blockquote>
                @endif
            </div>
        </div>

        @if($praiseReport->youtube_embed_url)
            <div class="pr-media">
                <iframe src="{{ $praiseReport->youtube_embed_url }}" title="{{ $praiseReport->title }} video" allowfullscreen></iframe>
            </div>
        @elseif($praiseReport->video_path)
            <div class="pr-media">
                <video controls src="{{ $praiseReport->video_url }}"></video>
            </div>
        @endif

        @if($praiseReport->audio_url)
            <div class="pr-audio">
                <h2>Listen to this testimony</h2>
                <audio controls src="{{ $praiseReport->audio_url }}"></audio>
            </div>
        @endif

        <section class="pr-reactions" aria-labelledby="reaction-heading">
            <div>
                <p class="eyebrow">Respond in faith</p>
                <h2 id="reaction-heading">Celebrate this praise report</h2>
            </div>
            <div class="pr-reaction-grid">
                @foreach(['amen' => '🙏 Amen', 'praise_god' => '❤️ Praise God', 'hallelujah' => '🙌 Hallelujah', 'praying' => '🤲 Praying'] as $type => $label)
                    <form method="POST" action="{{ route('praise-reports.reactions.store', $praiseReport) }}">
                        @csrf
                        <input type="hidden" name="reaction" value="{{ $type }}">
                        <button type="submit" class="pr-reaction-button">
                            <span>{{ $label }}</span>
                            <strong>{{ $reactionCounts[$type] ?? 0 }}</strong>
                        </button>
                    </form>
                @endforeach
            </div>
        </section>

        <section class="pr-comments" aria-labelledby="encouragement-heading">
            <div class="pr-comments-heading">
                <div>
                    <p class="eyebrow">Community encouragement</p>
                    <h2 id="encouragement-heading">Encouragements</h2>
                </div>
                <strong>{{ $praiseReport->approvedComments->count() }} approved</strong>
            </div>

            @forelse($praiseReport->approvedComments as $comment)
                <div class="pr-comment">
                    <strong>{{ $comment->name }}</strong>
                    <p>{{ $comment->message }}</p>
                </div>
            @empty
                <div class="pr-comments-empty">
                    <p>Be the first person to leave an encouraging message.</p>
                </div>
            @endforelse

            <form method="POST" action="{{ route('praise-reports.comments.store', $praiseReport) }}">
                @csrf
                <div class="pr-form-grid">
                    <input name="name" value="{{ old('name') }}" placeholder="Your name" required>
                    <input name="email" type="email" value="{{ old('email') }}" placeholder="Email (not shown publicly)">
                </div>
                <input name="website" class="hidden" tabindex="-1" autocomplete="off">
                <textarea name="message" rows="4" placeholder="Write an encouraging message" required>{{ old('message') }}</textarea>
                <button class="btn btn-primary" type="submit">Submit encouragement</button>
                <p class="pr-note">Messages are reviewed before they appear publicly.</p>
            </form>
        </section>
    </div>
</article>
@endsection
