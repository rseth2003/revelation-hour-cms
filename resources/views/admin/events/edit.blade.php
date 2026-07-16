<x-admin-layout title="Edit Event | RHMI CMS" heading="Edit Event">
    <div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-2xl font-bold text-[#072f68]">Edit event</h2>
        <p class="mt-1 text-sm text-slate-600">Update the event details, poster or publication status.</p>

        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="mt-8">
            @method('PUT')
            @include('admin.events._form', ['buttonText' => 'Save Changes'])
        </form>
    </div>
</x-admin-layout>
