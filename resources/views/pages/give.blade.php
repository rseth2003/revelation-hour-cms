@extends('layouts.app')

@section('title', 'Give | '.(($websiteSettings->church_name ?? null) ?: 'RHMI'))

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Give</p>
        <h1>Support the work of ministry</h1>
        <p>Your giving helps the church serve people, share the gospel and support ministry work.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="content-card">
            <h2>Giving Information</h2>

            @if($websiteSettings->giving_details)
                <div class="whitespace-pre-line leading-8 text-slate-700">
                    {{ $websiteSettings->giving_details }}
                </div>
            @else
                <p>Giving details will be published here by the church administration.</p>
            @endif
        </div>
    </div>
</section>
@endsection
