@extends('layouts.app')

@section('title', 'Give | '.(($websiteSettings->church_name ?? null) ?: 'RHMI'))

@section('content')
<section class="page-hero give-page-hero">
    <div class="container">
        <p class="eyebrow">Give & Partner</p>
        <h1>Your generosity makes ministry possible</h1>
        <p>Support the work of Revelation Hour Ministries International through the giving method most convenient for you.</p>
    </div>
</section>

<section class="section give-section">
    <div class="container">
        <div class="give-intro">
            <div><p class="eyebrow">Ways to give</p><h2 class="section-title-left">Choose a giving method</h2></div>
            <p>Use one of the verified giving methods provided by Revelation Hour Ministries International.</p>
        </div>

        <div class="giving-grid">
            @forelse($givingMethods as $method)
                <article class="giving-card giving-card--{{ $method->provider }} {{ $method->is_featured ? 'is-featured' : '' }}">
                    @if($method->is_featured)<span class="giving-featured">Recommended</span>@endif
                    <div class="giving-brand">
                        @if($method->icon_path)
                            <span class="giving-uploaded-logo"><img src="{{ asset('storage/'.$method->icon_path) }}" alt="{{ $method->title }} logo"></span>
                        @elseif($method->provider === 'mtn_momo')
                            <span class="giving-logo giving-logo-mtn"><span>MTN</span></span>
                        @elseif($method->provider === 'airtel_money')
                            <span class="giving-logo giving-logo-airtel">airtel</span>
                        @elseif($method->provider === 'cards')
                            <span class="giving-card-logos" aria-label="Visa and Mastercard">
                                <span class="giving-visa">VISA</span>
                                <span class="giving-mastercard"><i></i><i></i></span>
                            </span>
                        @else
                            <span class="giving-logo giving-logo-other">{{ mb_substr($method->title, 0, 1) }}</span>
                        @endif
                        <strong>{{ $method->title }}</strong>
                    </div>
                    <h3>{{ $method->title }}</h3>
                    <div class="giving-details">
                        @if($method->account_name)<p><span>Account name</span><strong>{{ $method->account_name }}</strong></p>@endif
                        @if($method->account_number)<p><span>Number / Code</span><strong class="giving-number">{{ $method->account_number }}</strong><button type="button" class="giving-copy" data-copy="{{ $method->account_number }}">Copy</button></p>@endif
                    </div>
                    @if(!$method->account_number)
                        <div class="giving-pending"><strong>Contact the church office for verified giving instructions</strong></div>
                    @endif
                    @if($method->instructions)<p class="giving-instructions">{{ $method->instructions }}</p>@endif
                    @if($method->button_url)<a class="btn btn-primary giving-action" href="{{ $method->button_url }}" target="_blank" rel="noopener">{{ $method->button_label ?: 'Continue' }}</a>@endif
                </article>
            @empty
                <div class="content-card giving-empty"><h2>Contact the church office for verified giving instructions</h2></div>
            @endforelse
        </div>

        <div class="giving-note"><div class="giving-note-icon">✓</div><div><h3>Give securely</h3><p>Confirm the official account name and number before completing a payment.</p></div></div>
    </div>
</section>
<script>
document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-copy]');
    if (!button) return;
    try {
        await navigator.clipboard.writeText(button.dataset.copy);
        const original = button.textContent;
        button.textContent = 'Copied';
        setTimeout(() => button.textContent = original, 1600);
    } catch (_) {}
});
</script>
@endsection
