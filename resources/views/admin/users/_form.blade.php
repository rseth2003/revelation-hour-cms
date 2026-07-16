@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Full name</label>
            <input name="name" value="{{ old('name', $user->name ?? '') }}"
                   class="w-full rounded-xl border-slate-300" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Email address</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                   class="w-full rounded-xl border-slate-300" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">CMS role</label>
            <select name="role" class="w-full rounded-xl border-slate-300" required>
                @foreach(\App\Models\User::ROLES as $value => $label)
                    <option value="{{ $value }}" @selected(old('role', $user->role ?? 'admin') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="space-y-5">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">
                Password {{ isset($user) ? '(leave blank to keep the current password)' : '' }}
            </label>
            <input type="password" name="password" class="w-full rounded-xl border-slate-300" {{ isset($user) ? '' : 'required' }}>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Confirm password</label>
            <input type="password" name="password_confirmation" class="w-full rounded-xl border-slate-300" {{ isset($user) ? '' : 'required' }}>
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $user->is_active ?? true))>
            <span>
                <strong class="block text-sm text-slate-800">Active account</strong>
                <span class="text-xs text-slate-500">Inactive accounts cannot access the CMS.</span>
            </span>
        </label>
    </div>
</div>

@if($errors->any())
    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
        <strong>Please correct the following:</strong>
        <ul class="mt-2 list-disc pl-5">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="mt-8 flex gap-3">
    <button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">{{ $buttonText }}</button>
    <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a>
</div>
