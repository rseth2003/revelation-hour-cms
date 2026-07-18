@foreach($heroSlides as $slide)
@php
    $displayImage = $slide->poster_image_url ?: $slide->background_image_url;
    $hasMedia = $slide->video_url || $displayImage;
@endphp

<article class="home-hero-slide home-hero-media-slide {{ $loop->first ? 'is-active' : '' }}">
    @if($slide->background_image_url)
        <div
            class="home-hero-background home-hero-blurred"
            style="background-image:url('{{ $slide->background_image_url }}')"
        ></div>
    @else
        <div class="home-hero-background home-hero-welcome"></div>
    @endif

    <div
        class="home-hero-shade"
        style="background:rgba(7,47,104,{{ number_format($slide->overlay_opacity / 100, 2, '.', '') }});"
    ></div>

    <div class="container {{ $hasMedia ? 'home-hero-media-layout hero-custom-media-layout' : 'home-hero-content' }}">
        <div class="{{ $hasMedia ? 'home-hero-media-copy' : '' }}">
            @if($slide->subtitle)
                <p class="eyebrow">{{ $slide->subtitle }}</p>
            @endif

            <h2>{{ $slide->title }}</h2>

            @if($slide->description)
                <p class="home-hero-copy">{{ $slide->description }}</p>
            @endif

            @if($slide->primary_button_text || $slide->secondary_button_text)
                <div class="hero-actions">
                    @if($slide->primary_button_text && $slide->primary_button_url)
                        <a
                            class="btn btn-primary"
                            href="{{ $slide->primary_button_url }}"
                            @if($slide->open_links_in_new_tab) target="_blank" rel="noopener noreferrer" @endif
                        >
                            {{ $slide->primary_button_text }}
                        </a>
                    @endif

                    @if($slide->secondary_button_text && $slide->secondary_button_url)
                        <a
                            class="btn btn-outline"
                            href="{{ $slide->secondary_button_url }}"
                            @if($slide->open_links_in_new_tab) target="_blank" rel="noopener noreferrer" @endif
                        >
                            {{ $slide->secondary_button_text }}
                        </a>
                    @endif
                </div>
            @endif
        </div>

        @if($slide->video_url)
            <div class="home-hero-poster-frame hero-slide-media-frame hero-slide-video-frame">
                <video
                    class="hero-slide-media"
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="metadata"
                    poster="{{ $displayImage }}"
                >
                    <source src="{{ $slide->video_url }}">
                </video>
            </div>
        @elseif($displayImage)
            <div class="home-hero-poster-frame hero-slide-media-frame">
                <img class="hero-slide-media" src="{{ $displayImage }}" alt="{{ $slide->title }}">
            </div>
        @endif
    </div>
</article>
@endforeach
