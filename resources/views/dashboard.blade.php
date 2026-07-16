<x-admin-layout title="RHMI CMS Dashboard" heading="Dashboard">
    <section class="mb-8 rounded-2xl bg-gradient-to-r from-[#072f68] to-[#0d5fa8] p-6 text-white shadow-lg">
        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-lime-300">Welcome back</p>
        <h2 class="mt-2 text-3xl font-bold">{{ auth()->user()->name }}</h2>
        <p class="mt-2 max-w-2xl text-blue-100">Manage the public website, daily messages, events, sermons, gallery and prayer requests from one place.</p>
    </section>
    @php
        $cards = [
            ['Word of the Day','Publish a typed devotion, poster or audio message.','◉','bg-lime-100 text-lime-700'],
            ['Live Events','Upload event posters and manage homepage slides.','▣','bg-blue-100 text-blue-700'],
            ['Sermons','Add audio, video, livestreams and sermon notes.','▶','bg-red-100 text-red-700'],
            ['Gallery','Organize church photos and ministry albums.','▧','bg-purple-100 text-purple-700'],
            ['Prayer Requests','Review and respond to submitted prayer requests.','♡','bg-pink-100 text-pink-700'],
            ['Website Settings','Update contacts, service times and social links.','⚙','bg-amber-100 text-amber-700'],
        ];
    @endphp
    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($cards as [$title,$description,$icon,$accent])
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="mb-4 flex items-start justify-between"><span class="grid h-12 w-12 place-items-center rounded-xl text-xl {{ $accent }}">{{ $icon }}</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">Coming next</span></div>
                <h3 class="text-lg font-bold text-[#072f68]">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>
                <button disabled class="mt-5 w-full cursor-not-allowed rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">Manage</button>
            </article>
        @endforeach
    </section>
    <section class="mt-8 grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border bg-white p-6 shadow-sm"><h3 class="font-bold text-[#072f68]">Quick status</h3><dl class="mt-5 space-y-4 text-sm"><div class="flex justify-between border-b pb-3"><dt class="text-slate-500">Public website</dt><dd class="font-semibold text-green-600">Online locally</dd></div><div class="flex justify-between border-b pb-3"><dt class="text-slate-500">Logged-in role</dt><dd class="font-semibold capitalize">{{ str_replace('_', ' ', auth()->user()->role ?? 'administrator') }}</dd></div><div class="flex justify-between"><dt class="text-slate-500">CMS version</dt><dd class="font-semibold">v0.6</dd></div></dl></div>
        <div class="rounded-2xl border bg-white p-6 shadow-sm"><h3 class="font-bold text-[#072f68]">Next module</h3><p class="mt-3 text-sm leading-6 text-slate-600">The next build will connect <strong>Live Events</strong> to the database so administrators can upload posters that appear automatically on the public homepage.</p></div>
    </section>
</x-admin-layout>
