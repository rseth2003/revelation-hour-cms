<x-admin-layout>
<div class="mb-8"><a href="{{ route('admin.communication.index') }}" class="text-sm font-semibold text-slate-500">← Communication Center</a><h1 class="mt-3 text-3xl font-bold text-[#072f68]">Message templates</h1></div>
@if(session('success'))<div class="mb-6 rounded-xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>@endif
<div class="grid gap-6 lg:grid-cols-[.8fr_1.2fr]">
<form method="POST" action="{{ route('admin.communication.templates.store') }}" class="rounded-2xl border bg-white p-6 shadow-sm">@csrf
<h2 class="text-xl font-bold text-[#072f68]">Create template</h2>
<div class="mt-5 space-y-4">
<div><label class="mb-2 block text-sm font-semibold">Name</label><input name="name" class="w-full rounded-xl border-slate-300" required></div>
<div><label class="mb-2 block text-sm font-semibold">Channel</label><select name="channel" class="w-full rounded-xl border-slate-300"><option value="email">Email</option><option value="sms">SMS</option><option value="whatsapp">WhatsApp</option></select></div>
<div><label class="mb-2 block text-sm font-semibold">Subject</label><input name="subject" class="w-full rounded-xl border-slate-300"></div>
<div><label class="mb-2 block text-sm font-semibold">Message</label><textarea name="body" rows="8" class="w-full rounded-xl border-slate-300" required></textarea></div>
<label class="flex gap-3"><input type="checkbox" name="is_active" value="1" checked><span class="text-sm font-semibold">Active</span></label>
<button class="rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Save template</button>
</div></form>
<section class="space-y-4">
@forelse($templates as $template)
<article class="rounded-2xl border bg-white p-5 shadow-sm"><div class="flex justify-between gap-4"><div><h3 class="font-bold text-[#072f68]">{{ $template->name }}</h3><p class="mt-1 text-xs font-semibold uppercase text-slate-500">{{ $template->channel }}</p></div><form method="POST" action="{{ route('admin.communication.templates.destroy',$template) }}" onsubmit="return confirm('Delete template?')">@csrf @method('DELETE')<button class="text-sm font-semibold text-red-600">Delete</button></form></div>@if($template->subject)<p class="mt-4 font-semibold">{{ $template->subject }}</p>@endif<p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $template->body }}</p></article>
@empty<div class="rounded-2xl border bg-white p-10 text-center text-slate-500">No templates yet.</div>@endforelse
</section>
</div>
</x-admin-layout>
