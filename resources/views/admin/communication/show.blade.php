<x-admin-layout>
<div class="mb-8 flex flex-wrap items-start justify-between gap-4">
<div><a href="{{ route('admin.communication.index') }}" class="text-sm font-semibold text-slate-500">← Communication Center</a><h1 class="mt-3 text-3xl font-bold text-[#072f68]">{{ $communication->title }}</h1><p class="mt-2 text-slate-600">{{ strtoupper($communication->channel) }} · {{ ucfirst($communication->status) }} · {{ $communication->recipient_count }} recipients</p></div>
<form method="POST" action="{{ route('admin.communication.destroy',$communication) }}" onsubmit="return confirm('Delete this communication?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-600 px-5 py-3 font-semibold text-white">Delete</button></form>
</div>
@if(session('success'))<div class="mb-6 rounded-xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>@endif
<div class="grid gap-6 lg:grid-cols-[.9fr_1.1fr]">
<section class="rounded-2xl border bg-white p-6 shadow-sm">
<h2 class="text-xl font-bold text-[#072f68]">Message</h2>
@if($communication->subject)<p class="mt-5 text-sm font-semibold text-slate-500">SUBJECT</p><p class="mt-1 font-bold">{{ $communication->subject }}</p>@endif
<p class="mt-5 whitespace-pre-line leading-7 text-slate-700">{{ $communication->body }}</p>
<div class="mt-6 border-t pt-5 text-sm text-slate-500">
<p>Audience: {{ str($communication->audience_type)->replace('_',' ')->title() }}</p>
@if($communication->scheduled_for)<p>Scheduled: {{ $communication->scheduled_for->format('d M Y, H:i') }}</p>@endif
@if($communication->notes)<p class="mt-3">Notes: {{ $communication->notes }}</p>@endif
</div>
</section>
<section class="rounded-2xl border bg-white p-6 shadow-sm">
<h2 class="text-xl font-bold text-[#072f68]">Prepared recipients</h2>
<p class="mt-2 text-sm text-slate-500">Only members with consent and a valid destination are listed.</p>
<div class="mt-5 max-h-[560px] overflow-y-auto divide-y">
@forelse($communication->recipients as $recipient)
<div class="flex items-center justify-between gap-4 py-3"><div><p class="font-semibold">{{ $recipient->member_name }}</p><p class="text-sm text-slate-500">{{ $recipient->destination }}</p></div><span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">{{ ucfirst($recipient->status) }}</span></div>
@empty<p class="py-10 text-center text-slate-500">No recipients have been prepared.</p>@endforelse
</div>
</section>
</div>
</x-admin-layout>
