<x-admin-layout title="New Event | RHMI CMS" heading="Create Event">
    <div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-2xl font-bold text-[#072f68]">Create a new event</h2>
        <p class="mt-1 text-sm text-slate-600">Add event information and upload a poster.</p>

        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="mt-8">
            @include('admin.events._form', ['buttonText' => 'Create Event'])
        </form>
    </div>
</x-admin-layout>
