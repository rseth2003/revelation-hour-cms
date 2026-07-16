<x-admin-layout title="Edit CMS User | RHMI CMS" heading="Edit CMS User">
<div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<h2 class="text-2xl font-bold text-[#072f68]">Edit {{ $user->name }}</h2>
<p class="mt-1 text-sm text-slate-600">Update role, access status or login information.</p>
<form method="POST" action="{{ route('admin.users.update',$user) }}" class="mt-8">
@method('PUT')
@include('admin.users._form',['buttonText'=>'Save Changes'])
</form>
</div>
</x-admin-layout>
