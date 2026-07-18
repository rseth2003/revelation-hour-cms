<x-admin-layout title="Edit Hero Slide | RHMI CMS" heading="Edit Hero Slide">
<div class="mx-auto max-w-6xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<h2 class="text-2xl font-bold text-[#072f68]">Edit {{ $heroSlide->title }}</h2>
<p class="mt-1 text-sm text-slate-600">Update content, images, scheduling and publishing.</p>
<form method="POST" action="{{ route('admin.hero-slides.update', $heroSlide) }}" enctype="multipart/form-data" class="mt-8">
@method('PUT')
@include('admin.hero-slides._form', ['buttonText' => 'Save Changes'])
</form>
</div>
</x-admin-layout>
