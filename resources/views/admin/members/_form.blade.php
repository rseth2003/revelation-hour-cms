@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <h3 class="text-lg font-bold text-[#072f68]">Personal Information</h3>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">First name</label>
                <input name="first_name" value="{{ old('first_name', $member->first_name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Last name</label>
                <input name="last_name" value="{{ old('last_name', $member->last_name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Other names</label>
            <input name="other_names" value="{{ old('other_names', $member->other_names ?? '') }}" class="w-full rounded-xl border-slate-300">
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Gender</label>
                <select name="gender" class="w-full rounded-xl border-slate-300">
                    <option value="">Not provided</option>
                    @foreach(['Male','Female','Other','Prefer not to say'] as $gender)
                        <option value="{{ $gender }}" @selected(old('gender', $member->gender ?? '') === $gender)>{{ $gender }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Date of birth</label>
                <input type="date" name="date_of_birth"
                       value="{{ old('date_of_birth', isset($member) && $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : '') }}"
                       class="w-full rounded-xl border-slate-300">
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Phone</label>
                <input name="phone" value="{{ old('phone', $member->phone ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Address</label>
            <input name="address" value="{{ old('address', $member->address ?? '') }}" class="w-full rounded-xl border-slate-300">
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Home area</label>
                <input name="home_area" value="{{ old('home_area', $member->home_area ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Occupation</label>
                <input name="occupation" value="{{ old('occupation', $member->occupation ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Marital status</label>
            <select name="marital_status" class="w-full rounded-xl border-slate-300">
                <option value="">Not provided</option>
                @foreach(['Single','Married','Divorced','Widowed','Separated','Prefer not to say'] as $status)
                    <option value="{{ $status }}" @selected(old('marital_status', $member->marital_status ?? '') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="space-y-5">
        <h3 class="text-lg font-bold text-[#072f68]">Church and Membership</h3>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Campus</label>
                <select name="campus_id" class="w-full rounded-xl border-slate-300">
                    <option value="">Not assigned</option>
                    @foreach($campuses as $campus)
                        <option value="{{ $campus->id }}" @selected((string) old('campus_id', $member->campus_id ?? '') === (string) $campus->id)>{{ $campus->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Ministry</label>
                <select name="ministry_id" class="w-full rounded-xl border-slate-300">
                    <option value="">Not assigned</option>
                    @foreach($ministries as $ministry)
                        <option value="{{ $ministry->id }}" @selected((string) old('ministry_id', $member->ministry_id ?? '') === (string) $ministry->id)>{{ $ministry->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Membership type</label>
                <select name="membership_type" class="w-full rounded-xl border-slate-300" required>
                    @foreach(\App\Models\Member::MEMBERSHIP_TYPES as $value => $label)
                        <option value="{{ $value }}" @selected(old('membership_type', $member->membership_type ?? 'visitor') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Status</label>
                <select name="membership_status" class="w-full rounded-xl border-slate-300" required>
                    @foreach(\App\Models\Member::STATUSES as $value => $label)
                        <option value="{{ $value }}" @selected(old('membership_status', $member->membership_status ?? 'pending') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">First visit date</label>
                <input type="date" name="first_visit_date"
                       value="{{ old('first_visit_date', isset($member) && $member->first_visit_date ? $member->first_visit_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-xl border-slate-300">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Joined date</label>
                <input type="date" name="joined_date"
                       value="{{ old('joined_date', isset($member) && $member->joined_date ? $member->joined_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-xl border-slate-300">
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <label class="flex gap-3 rounded-xl border bg-slate-50 p-4">
                <input type="checkbox" name="is_born_again" value="1" @checked(old('is_born_again', $member->is_born_again ?? false))>
                <span><strong class="block text-sm">Born Again</strong></span>
            </label>

            <label class="flex gap-3 rounded-xl border bg-slate-50 p-4">
                <input type="checkbox" name="is_baptized" value="1" @checked(old('is_baptized', $member->is_baptized ?? false))>
                <span><strong class="block text-sm">Baptized</strong></span>
            </label>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Member photo</label>
            <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            @if(isset($member) && $member->photo_url)
                <img src="{{ $member->photo_url }}" class="mt-4 h-40 w-40 rounded-xl object-cover">
            @endif
        </div>

        <h3 class="pt-3 text-lg font-bold text-[#072f68]">Communication Consent</h3>

        <div class="grid gap-3 sm:grid-cols-2">
            @foreach([
                ['sms_consent','Allow SMS'],
                ['email_consent','Allow Email'],
                ['whatsapp_consent','Allow WhatsApp'],
                ['birthday_message_consent','Allow Birthday Messages'],
            ] as [$field,$label])
                <label class="flex gap-3 rounded-xl border bg-slate-50 p-4">
                    <input type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $member->{$field} ?? false))>
                    <span><strong class="block text-sm">{{ $label }}</strong></span>
                </label>
            @endforeach
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Emergency contact name</label>
                <input name="emergency_contact_name" value="{{ old('emergency_contact_name', $member->emergency_contact_name ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Emergency contact phone</label>
                <input name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $member->emergency_contact_phone ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Private administrative notes</label>
            <textarea name="notes" rows="5" class="w-full rounded-xl border-slate-300">{{ old('notes', $member->notes ?? '') }}</textarea>
        </div>
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
    <a href="{{ route('admin.members.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a>
</div>
