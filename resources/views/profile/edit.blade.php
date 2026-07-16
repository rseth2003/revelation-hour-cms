<x-admin-layout title="Profile | RHMI CMS" heading="Profile">
    <div class="mx-auto max-w-5xl space-y-6">
        @if(session('status') === 'profile-updated')
            <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                Profile updated successfully.
            </div>
        @endif

        <section class="rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        <section class="rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </section>

        <section class="rounded-2xl border border-red-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </section>
    </div>
</x-admin-layout>
