<x-admin-layout title="Add Sermon | RHMI CMS" heading="Add Sermon">
    <div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-2xl font-bold text-[#072f68]">Create a sermon</h2>
        <p class="mt-1 text-sm text-slate-600">Add the message details, media and publication settings.</p>

        <form method="POST" action="{{ route('admin.sermons.store') }}" enctype="multipart/form-data" class="mt-8">
            @include('admin.sermons._form', ['buttonText' => 'Create Sermon'])
        </form>
    </div>
</x-admin-layout>
