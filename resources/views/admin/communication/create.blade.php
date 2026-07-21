<x-admin-layout>
<div class="mb-8">
    <a href="{{ route('admin.communication.index') }}" class="text-sm font-semibold text-slate-500">← Communication Center</a>
    <h1 class="mt-3 text-3xl font-bold text-[#072f68]">Compose communication</h1>
    <p class="mt-2 text-slate-600">Recipients are filtered automatically using their saved communication consent.</p>
</div>

<form method="POST" action="{{ route('admin.communication.store') }}" class="rounded-2xl border bg-white p-6 shadow-sm">
@csrf
<div class="grid gap-6 lg:grid-cols-2">
<div class="space-y-5">
    <div><label class="mb-2 block text-sm font-semibold">Internal title</label><input name="title" value="{{ old('title') }}" class="w-full rounded-xl border-slate-300" required></div>
    <div><label class="mb-2 block text-sm font-semibold">Channel</label><select name="channel" class="w-full rounded-xl border-slate-300"><option value="email">Email</option><option value="sms">SMS</option><option value="whatsapp">WhatsApp</option></select></div>
    <div><label class="mb-2 block text-sm font-semibold">Email subject</label><input name="subject" value="{{ old('subject') }}" class="w-full rounded-xl border-slate-300"></div>
    <div><label class="mb-2 block text-sm font-semibold">Message</label><textarea name="body" rows="10" class="w-full rounded-xl border-slate-300" required>{{ old('body') }}</textarea></div>
</div>

<div class="space-y-5">
    <div><label class="mb-2 block text-sm font-semibold">Audience</label>
    <select name="audience_type" class="w-full rounded-xl border-slate-300">
        <option value="all_members">All active members</option><option value="campus">Campus</option><option value="ministry">Ministry</option><option value="membership_type">Membership type</option><option value="membership_status">Membership status</option><option value="individual">Selected individuals</option>
    </select></div>
    <div><label class="mb-2 block text-sm font-semibold">Campus</label><select name="campus_id" class="w-full rounded-xl border-slate-300"><option value="">Select campus</option>@foreach($campuses as $campus)<option value="{{ $campus->id }}">{{ $campus->name }}</option>@endforeach</select></div>
    <div><label class="mb-2 block text-sm font-semibold">Ministry</label><select name="ministry_id" class="w-full rounded-xl border-slate-300"><option value="">Select ministry</option>@foreach($ministries as $ministry)<option value="{{ $ministry->id }}">{{ $ministry->name }}</option>@endforeach</select></div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div><label class="mb-2 block text-sm font-semibold">Membership type</label><select name="membership_type" class="w-full rounded-xl border-slate-300"><option value="">Select</option>@foreach(App\Models\Member::MEMBERSHIP_TYPES as $key=>$label)<option value="{{ $key }}">{{ $label }}</option>@endforeach</select></div>
        <div><label class="mb-2 block text-sm font-semibold">Status</label><select name="membership_status" class="w-full rounded-xl border-slate-300"><option value="">Select</option>@foreach(App\Models\Member::STATUSES as $key=>$label)<option value="{{ $key }}">{{ $label }}</option>@endforeach</select></div>
    </div>
    <div><label class="mb-2 block text-sm font-semibold">Individual members</label><select multiple name="member_ids[]" class="h-40 w-full rounded-xl border-slate-300">@foreach($members as $member)<option value="{{ $member->id }}">{{ $member->full_name }}</option>@endforeach</select></div>
    <div><label class="mb-2 block text-sm font-semibold">Schedule date and time</label><input type="datetime-local" name="scheduled_for" class="w-full rounded-xl border-slate-300"></div>
    <div><label class="mb-2 block text-sm font-semibold">Internal notes</label><textarea name="notes" rows="3" class="w-full rounded-xl border-slate-300"></textarea></div>
</div>
</div>
@if($errors->any())<div class="mt-6 rounded-xl bg-red-50 p-4 text-red-700"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="mt-8 flex flex-wrap gap-3">
<button name="action" value="draft" class="rounded-xl border px-5 py-3 font-semibold">Save draft</button>
<button name="action" value="prepare" class="rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Prepare recipients</button>
<button name="action" value="schedule" class="rounded-xl bg-lime-500 px-5 py-3 font-semibold text-[#072f68]">Schedule</button>
</div>
<p class="mt-4 text-xs text-slate-500">Provider-safe mode: this version prepares and records recipients but does not send real messages until provider credentials are configured.</p>
</form>
</x-admin-layout>
