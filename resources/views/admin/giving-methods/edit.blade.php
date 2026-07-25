<x-admin-layout title="Edit Giving Method | RHMI CMS" heading="Edit Giving Method">
<div class="rounded-2xl border bg-white p-6 shadow-sm"><form method="POST" action="{{ route('admin.giving-methods.update',$method) }}">@method('PUT') @include('admin.giving-methods._form',['buttonText'=>'Save Changes'])</form></div>
</x-admin-layout>
