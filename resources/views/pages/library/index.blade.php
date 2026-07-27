@extends('layouts.app')

@section('title', 'eLibrary | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">RHMI eLibrary</p>
        <h1>Resources for faith and growth</h1>
        <p>Read and download books, Bible studies, sermon notes and church publications.</p>
    </div>
</section>

@if($featured->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Featured Resources</p>
            <h2>Selected for you</h2>
        </div>
        <div class="library-grid">
            @foreach($featured as $resource)
                @include('pages.library._card', ['resource' => $resource])
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section section-soft">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Browse the Library</p>
            <h2>Find a resource</h2>
        </div>
        <form method="GET" class="library-filter">
            <input name="search" value="{{ request('search') }}" placeholder="Search by title, author or subject" aria-label="Search resources">
            <select name="category" aria-label="Filter by category">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }} ({{ $category->resources_count }})</option>
                @endforeach
            </select>
            <select name="type" aria-label="Filter by resource type">
                <option value="">All resource types</option>
                @foreach(\App\Models\LibraryResource::TYPES as $value => $label)
                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary">Search</button>
        </form>
        <div class="library-grid">
            @forelse($resources as $resource)
                @include('pages.library._card', ['resource' => $resource])
            @empty
                <div class="empty-state">No resources match your search.</div>
            @endforelse
        </div>
        <div class="mt-8">{{ $resources->links() }}</div>
    </div>
</section>
@endsection
