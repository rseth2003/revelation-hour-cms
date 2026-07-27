@csrf

@php
    $savedModules = old('modules', isset($user) ? $user->effectiveModules() : []);
    $allModules = old('all_modules', isset($user) ? $user->hasAllModules() : false);
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Full name</label>
            <input name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Email address</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">CMS role</label>
            <select name="role" class="w-full rounded-xl border-slate-300" required>
                @foreach(\App\Models\User::ROLES as $value => $label)
                    <option value="{{ $value }}" @selected(old('role', $user->role ?? 'admin') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <p class="mt-2 text-xs text-slate-500">The role describes the person’s responsibility. Module access below controls what they can open.</p>
        </div>
    </div>

    <div class="space-y-5">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Password {{ isset($user) ? '(leave blank to keep the current password)' : '' }}</label>
            <input type="password" name="password" class="w-full rounded-xl border-slate-300" {{ isset($user) ? '' : 'required' }}>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Confirm password</label>
            <input type="password" name="password_confirmation" class="w-full rounded-xl border-slate-300" {{ isset($user) ? '' : 'required' }}>
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active ?? true))>
            <span><strong class="block text-sm text-slate-800">Active account</strong><span class="text-xs text-slate-500">Inactive accounts cannot access the CMS.</span></span>
        </label>
    </div>
</div>

<section class="mt-8 rounded-2xl border border-blue-100 bg-blue-50/50 p-5 sm:p-6" data-module-selector>
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h3 class="text-lg font-bold text-[#072f68]">Module access</h3>
            <p class="mt-1 text-sm text-slate-600">Select every module this user is allowed to manage. A Senior Usher can, for example, receive only Members and Attendance.</p>
        </div>
        <label class="flex items-center gap-3 rounded-xl bg-white px-4 py-3 font-semibold text-[#072f68] shadow-sm">
            <input type="checkbox" name="all_modules" value="1" data-all-modules @checked($allModules)>
            Select all modules
        </label>
    </div>

    <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3" data-module-list>
        @foreach(\App\Models\User::MODULES as $value => $label)
            <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-4">
                <input type="checkbox" name="modules[]" value="{{ $value }}" data-module-checkbox @checked(in_array($value, $savedModules, true))>
                <span><strong class="block text-sm text-slate-800">{{ $label }}</strong><span class="text-xs text-slate-500">Allow access to this area.</span></span>
            </label>
        @endforeach
    </div>
</section>

@if($errors->any())
<div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700"><strong>Please correct the following:</strong><ul class="mt-2 list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="mt-8 flex gap-3">
    <button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">{{ $buttonText }}</button>
    <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const root = document.querySelector('[data-module-selector]');
    if (!root) return;
    const all = root.querySelector('[data-all-modules]');
    const boxes = [...root.querySelectorAll('[data-module-checkbox]')];
    const sync = () => boxes.forEach(box => { box.disabled = all.checked; if (all.checked) box.checked = true; });
    all.addEventListener('change', sync);
    boxes.forEach(box => box.addEventListener('change', () => { if (!box.checked) all.checked = false; }));
    sync();
});
</script>
