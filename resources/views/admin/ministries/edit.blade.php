<x-admin-layout title="Edit Ministry | RHMI CMS" heading="Edit Ministry">
    <div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-2xl font-bold text-[#072f68]">Edit ministry</h2>
        <p class="mt-1 text-sm text-slate-600">Update ministry details, leadership and images.</p>

        <form method="POST" action="{{ route('admin.ministries.update', $ministry) }}" enctype="multipart/form-data" class="mt-8">
            @method('PUT')
            @include('admin.ministries._form', ['buttonText' => 'Save Changes'])
        </form>
    </div>
</x-admin-layout>
