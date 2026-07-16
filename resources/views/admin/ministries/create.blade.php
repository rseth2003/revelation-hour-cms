<x-admin-layout title="Add Ministry | RHMI CMS" heading="Add Ministry">
    <div class="mx-auto max-w-5xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-2xl font-bold text-[#072f68]">Create a ministry</h2>
        <p class="mt-1 text-sm text-slate-600">Add ministry information, leadership details and images.</p>

        <form method="POST" action="{{ route('admin.ministries.store') }}" enctype="multipart/form-data" class="mt-8">
            @include('admin.ministries._form', ['buttonText' => 'Create Ministry'])
        </form>
    </div>
</x-admin-layout>
