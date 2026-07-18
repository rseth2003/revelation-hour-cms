<x-admin-layout title="Hero Slider | RHMI CMS" heading="Hero Slider">
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
<div>
<h2 class="text-2xl font-bold text-[#072f68]">Hero Slider Manager</h2>
<p class="mt-1 text-sm text-slate-600">Create and schedule homepage campaign slides without changing the existing welcome, daily word or sermon slides.</p>
</div>
<a href="{{ route('admin.hero-slides.create') }}" class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68]">+ Add Hero Slide</a>
</div>

@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

@if($slides->isEmpty())
<div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">No custom hero slides have been created yet.</div>
@else
<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
@foreach($slides as $slide)
<article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
@if($slide->background_image_url)
<img src="{{ $slide->background_image_url }}" alt="{{ $slide->title }}" class="h-48 w-full object-cover">
@else
<div class="grid h-48 place-items-center bg-gradient-to-r from-[#072f68] to-[#0d5fa8] text-white">No background image</div>
@endif
<div class="p-5">
<div class="flex items-start justify-between gap-3">
<div><p class="text-xs font-bold uppercase tracking-wide text-lime-600">Order {{ $slide->sort_order }}</p><h3 class="mt-1 text-lg font-bold text-[#072f68]">{{ $slide->title }}</h3></div>
<span class="rounded-full px-3 py-1 text-xs font-bold {{ $slide->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">{{ $slide->is_published ? 'Published' : 'Draft' }}</span>
</div>
@if($slide->subtitle)<p class="mt-2 text-sm font-semibold text-slate-700">{{ $slide->subtitle }}</p>@endif
@if($slide->description)<p class="mt-2 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($slide->description,130) }}</p>@endif
<div class="mt-5 flex gap-2">
<a href="{{ route('admin.hero-slides.edit',$slide) }}" class="flex-1 rounded-lg bg-[#072f68] px-4 py-2 text-center text-sm font-semibold text-white">Edit</a>
<form method="POST" action="{{ route('admin.hero-slides.destroy',$slide) }}" class="flex-1" onsubmit="return confirm('Delete this hero slide?')">
@csrf
@method('DELETE')
<button class="w-full rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700">Delete</button>
</form>
</div>
</div>
</article>
@endforeach
</div>
<div class="mt-6">{{ $slides->links() }}</div>
@endif
</x-admin-layout>
