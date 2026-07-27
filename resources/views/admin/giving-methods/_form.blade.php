@csrf
<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Public title</label>
            <input name="title" value="{{ old('title', $method->title) }}" class="w-full rounded-xl border-slate-300" required>
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Payment method type</label>
            <select name="provider" class="w-full rounded-xl border-slate-300" required>
                @foreach(\App\Models\GivingMethod::PROVIDERS as $value => $label)
                    <option value="{{ $value }}" @selected(old('provider', $method->provider ?: 'custom') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <p class="mt-2 text-xs text-slate-500">Choose “Other Method” for any provider not listed.</p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Logo or icon</label>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4">
                <div class="flex flex-wrap items-center gap-4">
                    <div id="giving-icon-preview" class="grid h-16 w-24 place-items-center overflow-hidden rounded-xl border bg-white p-2">
                        @if($method->icon_path)
                            <img src="{{ asset('storage/'.$method->icon_path) }}" alt="{{ $method->title }} logo" class="max-h-12 max-w-20 object-contain">
                        @else
                            <span class="text-xs font-semibold text-slate-400">No icon</span>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <input id="giving-icon-input" type="file" name="icon" accept=".png,.jpg,.jpeg,.webp,.svg,image/png,image/jpeg,image/webp,image/svg+xml" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-[#072f68] file:px-4 file:py-2 file:font-semibold file:text-white">
                        <p class="mt-2 text-xs text-slate-500">PNG, JPG, WEBP or SVG. Maximum 2 MB. Use a transparent logo where possible.</p>
                    </div>
                </div>
                @if($method->icon_path)
                    <label class="mt-4 flex items-center gap-2 text-sm text-red-700">
                        <input type="checkbox" name="remove_icon" value="1" @checked(old('remove_icon'))>
                        Remove the current icon
                    </label>
                @endif
                @error('icon')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Account or registered name</label>
            <input name="account_name" value="{{ old('account_name', $method->account_name) }}" class="w-full rounded-xl border-slate-300" placeholder="Revelation Hour Ministries International">
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Phone number or payment code</label>
            <input name="account_number" value="{{ old('account_number', $method->account_number) }}" class="w-full rounded-xl border-slate-300" placeholder="Official number or code">
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Giving instructions</label>
            <textarea name="instructions" rows="6" class="w-full rounded-xl border-slate-300" placeholder="Clear steps for using this payment method">{{ old('instructions', $method->instructions) }}</textarea>
        </div>
    </div>

    <div class="space-y-5">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Optional button label</label>
                <input name="button_label" value="{{ old('button_label', $method->button_label) }}" class="w-full rounded-xl border-slate-300" placeholder="Give now">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Optional button URL</label>
                <input type="url" name="button_url" value="{{ old('button_url', $method->button_url) }}" class="w-full rounded-xl border-slate-300" placeholder="https://...">
            </div>
        </div>

        <input type="hidden" name="bank_name" value="">
        <input type="hidden" name="branch_name" value="">
        <input type="hidden" name="swift_code" value="">

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Display order</label>
            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $method->sort_order ?? 0) }}" class="w-full rounded-xl border-slate-300">
            <p class="mt-2 text-xs text-slate-500">Lower numbers appear first after featured methods.</p>
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $method->is_featured))>
            <span><strong class="block text-sm">Feature this method</strong><span class="text-xs text-slate-500">Featured methods receive stronger emphasis.</span></span>
        </label>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_published" type="checkbox" value="1" @checked(old('is_published', $method->exists ? $method->is_published : true))>
            <span><strong class="block text-sm">Publish on website</strong><span class="text-xs text-slate-500">Draft methods stay hidden from visitors.</span></span>
        </label>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">{{ $buttonText }}</button>
    <a href="{{ route('admin.giving-methods.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('giving-icon-input');
    const preview = document.getElementById('giving-icon-preview');
    if (!input || !preview) return;

    input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = event => {
            preview.innerHTML = '';
            const image = document.createElement('img');
            image.src = event.target.result;
            image.alt = 'Selected payment method icon';
            image.className = 'max-h-12 max-w-20 object-contain';
            preview.appendChild(image);
        };
        reader.readAsDataURL(file);
    });
});
</script>
