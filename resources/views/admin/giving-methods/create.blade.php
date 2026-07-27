<x-admin-layout title="Add Giving Method | RHMI CMS" heading="Add Giving Method">
<div class="rounded-2xl border bg-white p-6 shadow-sm">
    <form method="POST" action="{{ route('admin.giving-methods.store') }}" enctype="multipart/form-data">
        @include('admin.giving-methods._form',['buttonText'=>'Create Giving Method'])
    </form>
</div>
</x-admin-layout>
