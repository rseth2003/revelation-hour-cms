@if(isset($homepageLivestream) && $homepageLivestream)
<section class="home-live-promo" aria-labelledby="home-live-title">
    <div class="container">
        <div class="home-live-shell">
            <a class="home-live-media" href="{{ route('livestreams.show', $homepageLivestream) }}" aria-label="Open {{ $homepageLivestream->title }}">
                @if($homepageLivestream->thumbnail_url)
                    <img src="{{ $homepageLivestream->thumbnail_url }}" alt="{{ $homepageLivestream->title }} livestream poster">
                @else
                    <div class="home-live-placeholder" aria-hidden="true">
                        <span>▶</span>
                    </div>
                @endif

                <span class="home-live-media-status {{ $homepageLivestream->status === 'live' ? 'is-live' : '' }}">
                    {{ $homepageLivestream->status === 'live' ? '● Live now' : 'Upcoming' }}
                </span>
                <span class="home-live-play" aria-hidden="true">▶</span>
            </a>

            <div class="home-live-content">
                <p class="home-live-kicker">
                    {{ $homepageLivestream->status === 'live' ? 'Live worship' : 'Next livestream' }}
                </p>

                <h2 id="home-live-title">{{ $homepageLivestream->title }}</h2>

                @if($homepageLivestream->subtitle)
                    <p class="home-live-subtitle">{{ $homepageLivestream->subtitle }}</p>
                @endif

                <div class="home-live-meta">
                    @if($homepageLivestream->scheduled_start)
                        <span>
                            <strong>{{ $homepageLivestream->scheduled_start->format('l, F j') }}</strong>
                            {{ $homepageLivestream->scheduled_start->format('g:i A') }}
                        </span>
                    @endif

                    @if($homepageLivestream->speaker)
                        <span>
                            <strong>Speaker</strong>
                            {{ $homepageLivestream->speaker }}
                        </span>
                    @endif
                </div>

                @if($homepageLivestream->status === 'upcoming' && $homepageLivestream->scheduled_start)
                    <div class="live-countdown home-live-countdown" data-countdown="{{ $homepageLivestream->scheduled_start->toIso8601String() }}" aria-label="Countdown to livestream"></div>
                @endif

                <div class="home-live-actions">
                    <a class="btn btn-primary" href="{{ route('livestreams.show', $homepageLivestream) }}">
                        {{ $homepageLivestream->status === 'live' ? 'Watch live' : 'View broadcast' }}
                    </a>
                    <a class="home-live-archive-link" href="{{ route('livestreams.index') }}">All broadcasts →</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
