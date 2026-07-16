<x-admin-layout title="Website Settings | RHMI CMS" heading="Website Settings">
<div class="mx-auto max-w-6xl">
    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#072f68]">Website Settings</h2>
            <p class="mt-1 text-sm text-slate-600">
                Update church identity, contacts, social links, service information and footer details.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-8 lg:grid-cols-2">
                <section class="space-y-5">
                    <h3 class="text-lg font-bold text-[#072f68]">Church Identity</h3>

                    <div>
                        <label class="mb-2 block text-sm font-semibold">Church name</label>
                        <input name="church_name" value="{{ old('church_name', $settings->church_name) }}"
                               class="w-full rounded-xl border-slate-300" required>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold">Short name</label>
                            <input name="short_name" value="{{ old('short_name', $settings->short_name) }}"
                                   class="w-full rounded-xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold">Tagline</label>
                            <input name="tagline" value="{{ old('tagline', $settings->tagline) }}"
                                   class="w-full rounded-xl border-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold">Church logo</label>
                        <input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp"
                               class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">

                        @if($settings->logo_url)
                            <img src="{{ $settings->logo_url }}" class="mt-4 h-32 w-48 rounded-xl bg-slate-100 object-contain p-2">
                        @else
                            <img src="{{ asset('images/revelation-hour-logo.jpg') }}" class="mt-4 h-32 w-48 rounded-xl bg-slate-100 object-contain p-2">
                        @endif
                    </div>

                    <h3 class="pt-4 text-lg font-bold text-[#072f68]">Contacts</h3>

                    <div>
                        <label class="mb-2 block text-sm font-semibold">Address</label>
                        <input name="address" value="{{ old('address', $settings->address) }}"
                               class="w-full rounded-xl border-slate-300">
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold">Primary phone</label>
                            <input name="phone_primary" value="{{ old('phone_primary', $settings->phone_primary) }}"
                                   class="w-full rounded-xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold">Secondary phone</label>
                            <input name="phone_secondary" value="{{ old('phone_secondary', $settings->phone_secondary) }}"
                                   class="w-full rounded-xl border-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold">Email address</label>
                        <input type="email" name="email" value="{{ old('email', $settings->email) }}"
                               class="w-full rounded-xl border-slate-300">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold">Service times</label>
                        <textarea name="service_times" rows="5"
                                  class="w-full rounded-xl border-slate-300">{{ old('service_times', $settings->service_times) }}</textarea>
                    </div>
                </section>

                <section class="space-y-5">
                    <h3 class="text-lg font-bold text-[#072f68]">Social Media</h3>

                    @foreach([
                        ['facebook_url','Facebook'],
                        ['instagram_url','Instagram'],
                        ['youtube_url','YouTube'],
                        ['tiktok_url','TikTok'],
                        ['telegram_url','Telegram'],
                        ['whatsapp_url','WhatsApp'],
                        ['x_url','X'],
                    ] as [$field,$label])
                        <div>
                            <label class="mb-2 block text-sm font-semibold">{{ $label }} link</label>
                            <input type="url" name="{{ $field }}" value="{{ old($field, $settings->{$field}) }}"
                                   class="w-full rounded-xl border-slate-300">
                        </div>
                    @endforeach

                    <h3 class="pt-4 text-lg font-bold text-[#072f68]">Giving and Footer</h3>

                    <div>
                        <label class="mb-2 block text-sm font-semibold">Giving details</label>
                        <textarea name="giving_details" rows="5"
                                  class="w-full rounded-xl border-slate-300">{{ old('giving_details', $settings->giving_details) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold">Footer text</label>
                        <textarea name="footer_text" rows="4"
                                  class="w-full rounded-xl border-slate-300">{{ old('footer_text', $settings->footer_text) }}</textarea>
                    </div>
                </section>
            </div>

            @if($errors->any())
                <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-8">
                <button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">
                    Save Website Settings
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
