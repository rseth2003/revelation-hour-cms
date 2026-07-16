<x-admin-layout title="Edit Member | RHMI CMS" heading="Edit Member">
<div class="mx-auto max-w-6xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<h2 class="text-2xl font-bold text-[#072f68]">Edit {{ $member->full_name }}</h2>
<p class="mt-1 text-sm text-slate-600">Update membership and contact information.</p>
<form method="POST" action="{{ route('admin.members.update',$member) }}" enctype="multipart/form-data" class="mt-8">
@method('PUT')
@include('admin.members._form',['buttonText'=>'Save Changes'])
</form>
</div>
</x-admin-layout>
