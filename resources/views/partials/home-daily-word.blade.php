<section class="section section-soft" id="word-of-the-day">
    <div class="container daily-home-grid">
        <div>
            @if($featuredDailyWord?->poster_url)
                <img src="{{ $featuredDailyWord->poster_url }}" alt="{{ $featuredDailyWord->title }}" class="daily-home-poster">
            @else
                <div class="daily-home-placeholder">
                    <span>{{ $featuredDailyWord?->scripture_reference ?: 'Word of the Day' }}</span>
                </div>
            @endif
        </div>

        <div>
            <p class="eyebrow">Daily Encouragement</p>
            <h2 class="section-title-left">{{ $featuredDailyWord?->title ?: 'Word of the Day' }}</h2>

            @if($featuredDailyWord)
                <p class="daily-reference">{{ $featuredDailyWord->scripture_reference }}</p>

                @if($featuredDailyWord->scripture_text)
                    <blockquote>{{ $featuredDailyWord->scripture_text }}</blockquote>
                @endif

                @if($featuredDailyWord->message)
                    <p>{{ \Illuminate\Support\Str::limit($featuredDailyWord->message, 320) }}</p>
                @endif

                @if($featuredDailyWord->audio_url)
                    <audio controls class="daily-audio"><source src="{{ $featuredDailyWord->audio_url }}"></audio>
                @endif
            @else
                <p>No daily message has been published yet.</p>
            @endif

            <div class="hero-actions">
                <a class="btn btn-primary" href="{{ route('daily-words') }}">View Daily Messages</a>
            </div>
        </div>
    </div>
</section>
