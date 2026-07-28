@extends('layouts.app')
@section('title','Praise Reports | Revelation Hour Ministries International')
@section('description','Read testimonies and praise reports from people whose lives have been touched through RHMI.')
@section('content')
<section class="pr-page-hero"><div class="container"><p class="eyebrow">Community</p><h1>Praise Reports</h1><p>Real stories of answered prayer, restoration, healing and God’s faithfulness.</p></div></section>
<section class="section"><div class="container">
<form class="pr-filter" method="GET"><input name="q" value="{{ request('q') }}" placeholder="Search praise reports"><select name="category"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category }}" @selected(request('category')===$category)>{{ $category }}</option>@endforeach</select><button class="btn btn-primary">Search</button></form>
<div class="pr-grid">@forelse($reports as $report)<article class="pr-card">@if($report->photo_url)<img src="{{ $report->photo_url }}" alt="{{ $report->person_name ?: $report->title }}">@else<div class="pr-card-placeholder">🙌</div>@endif<div class="pr-card-body">@if($report->category)<span class="pr-chip">{{ $report->category }}</span>@endif<h2>{{ $report->title }}</h2>@if($report->person_name)<p class="pr-person">{{ $report->person_name }}</p>@endif<p>{{ $report->summary ?: \Illuminate\Support\Str::limit(strip_tags($report->testimony),170) }}</p><a class="text-link" href="{{ route('praise-reports.show',$report) }}">Read the full testimony →</a></div></article>@empty<p>No praise reports have been published yet.</p>@endforelse</div><div class="mt-8">{{ $reports->links() }}</div>
</div></section>
@endsection
