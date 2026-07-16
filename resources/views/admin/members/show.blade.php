<x-admin-layout title="Member Profile | RHMI CMS" heading="Member Profile">
<div class="mx-auto max-w-6xl">
@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

<div class="grid gap-6 lg:grid-cols-[340px_1fr]">
<aside class="rounded-2xl border bg-white p-6 text-center shadow-sm">
@if($member->photo_url)
<img src="{{ $member->photo_url }}" class="mx-auto h-52 w-52 rounded-2xl object-cover">
@else
<div class="mx-auto grid h-52 w-52 place-items-center rounded-2xl bg-blue-100 text-5xl font-bold text-blue-700">{{ strtoupper(substr($member->first_name,0,1).substr($member->last_name,0,1)) }}</div>
@endif
<h2 class="mt-5 text-2xl font-bold text-[#072f68]">{{ $member->full_name }}</h2>
<p class="mt-1 text-sm text-slate-500">{{ $member->member_number }}</p>
<p class="mt-3"><span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">{{ \App\Models\Member::STATUSES[$member->membership_status] ?? ucfirst($member->membership_status) }}</span></p>

<div class="mt-6 flex gap-3">
<a href="{{ route('admin.members.edit',$member) }}" class="flex-1 rounded-xl bg-[#072f68] px-4 py-3 text-sm font-semibold text-white">Edit</a>
<form method="POST" action="{{ route('admin.members.destroy',$member) }}" class="flex-1" onsubmit="return confirm('Delete this member record?')">@csrf @method('DELETE')<button class="w-full rounded-xl border border-red-200 px-4 py-3 text-sm font-semibold text-red-700">Delete</button></form>
</div>
</aside>

<section class="space-y-6">
<div class="rounded-2xl border bg-white p-6 shadow-sm">
<h3 class="text-xl font-bold text-[#072f68]">Contact and Personal Details</h3>
<div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
@foreach([
['Phone',$member->phone ?: 'Not provided'],
['Email',$member->email ?: 'Not provided'],
['Gender',$member->gender ?: 'Not provided'],
['Date of Birth',$member->date_of_birth?->format('j M Y') ?: 'Not provided'],
['Home Area',$member->home_area ?: 'Not provided'],
['Occupation',$member->occupation ?: 'Not provided'],
['Marital Status',$member->marital_status ?: 'Not provided'],
['Address',$member->address ?: 'Not provided'],
] as [$label,$value])
<div class="rounded-xl bg-slate-50 p-4"><p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $label }}</p><p class="mt-1 font-semibold text-slate-700">{{ $value }}</p></div>
@endforeach
</div>
</div>

<div class="rounded-2xl border bg-white p-6 shadow-sm">
<h3 class="text-xl font-bold text-[#072f68]">Church Information</h3>
<div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
@foreach([
['Membership Type',\App\Models\Member::MEMBERSHIP_TYPES[$member->membership_type] ?? ucfirst($member->membership_type)],
['Campus',$member->campus?->name ?: 'Not assigned'],
['Ministry',$member->ministry?->name ?: 'Not assigned'],
['First Visit',$member->first_visit_date?->format('j M Y') ?: 'Not provided'],
['Joined Date',$member->joined_date?->format('j M Y') ?: 'Not provided'],
['Born Again',$member->is_born_again ? 'Yes' : 'No'],
['Baptized',$member->is_baptized ? 'Yes' : 'No'],
] as [$label,$value])
<div class="rounded-xl bg-slate-50 p-4"><p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $label }}</p><p class="mt-1 font-semibold text-slate-700">{{ $value }}</p></div>
@endforeach
</div>
</div>

<div class="rounded-2xl border bg-white p-6 shadow-sm">
<h3 class="text-xl font-bold text-[#072f68]">Communication Consent</h3>
<div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
@foreach([
['SMS',$member->sms_consent],
['Email',$member->email_consent],
['WhatsApp',$member->whatsapp_consent],
['Birthday Messages',$member->birthday_message_consent],
] as [$label,$allowed])
<div class="rounded-xl p-4 {{ $allowed ? 'bg-green-50' : 'bg-slate-50' }}"><p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $label }}</p><p class="mt-1 font-semibold {{ $allowed ? 'text-green-700' : 'text-slate-700' }}">{{ $allowed ? 'Allowed' : 'Not allowed' }}</p></div>
@endforeach
</div>
</div>

@if($member->notes)
<div class="rounded-2xl border bg-white p-6 shadow-sm"><h3 class="text-xl font-bold text-[#072f68]">Private Notes</h3><p class="mt-4 whitespace-pre-line leading-7 text-slate-700">{{ $member->notes }}</p></div>
@endif
</section>
</div>
</div>
</x-admin-layout>
