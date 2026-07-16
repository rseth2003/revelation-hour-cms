<x-admin-layout title="Add CMS User | RHMI CMS" heading="Add CMS User">
<div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<h2 class="text-2xl font-bold text-[#072f68]">Create a CMS account</h2>
<p class="mt-1 text-sm text-slate-600">Assign the correct role based on the person's church responsibility.</p>
<form method="POST" action="{{ route('admin.users.store') }}" class="mt-8">
@include('admin.users._form',['buttonText'=>'Create User'])
</form>
</div>
</x-admin-layout>
