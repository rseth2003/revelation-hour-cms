<x-admin-layout title="New Gallery Album | RHMI CMS" heading="New Gallery Album">
    <div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-2xl font-bold text-[#072f68]">Create a gallery album</h2>
        <p class="mt-1 text-sm text-slate-600">Add album information and upload multiple photos.</p>

        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="mt-8">
            @include('admin.gallery._form', ['buttonText' => 'Create Album'])
        </form>
    </div>
</x-admin-layout>
