@if ($stream->embed_url)
    <div class="live-player">
        <iframe
            src="{{ $stream->embed_url }}"
            title="{{ $stream->title }}"
            allow="autoplay; encrypted-media; picture-in-picture"
            allowfullscreen
            loading="lazy"
        ></iframe>
    </div>
@else
    <div class="external-stream-card">
        @if ($stream->thumbnail_url)
            <img src="{{ $stream->thumbnail_url }}" alt="{{ $stream->title }}">
        @endif

        <a
            class="btn btn-primary"
            href="{{ $stream->stream_url }}"
            target="_blank"
            rel="noopener"
        >
            Open Broadcast
        </a>
    </div>
@endif
