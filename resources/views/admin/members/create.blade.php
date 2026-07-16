<x-admin-layout title="Add Person | RHMI CMS" heading="Add Person">
<div class="mx-auto max-w-6xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<h2 class="text-2xl font-bold text-[#072f68]">Create member or visitor record</h2>
<p class="mt-1 text-sm text-slate-600">Only record information the person has voluntarily provided.</p>
<form method="POST" action="{{ route('admin.members.store') }}" enctype="multipart/form-data" class="mt-8">
@include('admin.members._form',['buttonText'=>'Create Record'])
</form>
</div>
</x-admin-layout>
