<x-admin-layout title="New Hero Slide | RHMI CMS" heading="New Hero Slide">
<div class="mx-auto max-w-6xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<h2 class="text-2xl font-bold text-[#072f68]">Create a homepage hero slide</h2>
<p class="mt-1 text-sm text-slate-600">Custom slides appear before the existing welcome, Word of the Day and featured sermon slides.</p>
<form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data" class="mt-8">
@include('admin.hero-slides._form', ['buttonText' => 'Create Slide'])
</form>
</div>
</x-admin-layout>
