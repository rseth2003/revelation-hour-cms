<x-admin-layout title="Edit Sermon | RHMI CMS" heading="Edit Sermon">
    <div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-2xl font-bold text-[#072f68]">Edit sermon</h2>
        <p class="mt-1 text-sm text-slate-600">Update the sermon details and media.</p>

        <form method="POST" action="{{ route('admin.sermons.update', $sermon) }}" enctype="multipart/form-data" class="mt-8">
            @method('PUT')
            @include('admin.sermons._form', ['buttonText' => 'Save Changes'])
        </form>
    </div>
</x-admin-layout>
