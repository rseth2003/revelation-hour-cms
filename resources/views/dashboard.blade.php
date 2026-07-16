<x-admin-layout title="RHMI CMS Dashboard" heading="Dashboard">
    <section class="mb-8 rounded-2xl bg-gradient-to-r from-[#072f68] to-[#0d5fa8] p-6 text-white shadow-lg">
        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-lime-300">Welcome back</p>
        <h2 class="mt-2 text-3xl font-bold">{{ auth()->user()->name }}</h2>
        <p class="mt-2 max-w-2xl text-blue-100">Manage the public website, ministries, events, sermons, gallery and prayer requests from one place.</p>
    </section>

    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @php
            $activeCards = [
                ['Live Events', 'Upload event posters and manage homepage slides.', '▣', 'admin.events.index', 'bg-blue-100 text-blue-700'],
                ['Ministries', 'Manage ministry pages, leaders, schedules and images.', '◆', 'admin.ministries.index', 'bg-purple-100 text-purple-700'],
                ['Sermons', 'Publish video, audio, sermon notes and featured messages.', '▶', 'admin.sermons.index', 'bg-red-100 text-red-700'],
            ];
        @endphp

        @foreach($activeCards as [$title, $description, $icon, $routeName, $accent])
            <article class="rounded-2xl border border-blue-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex justify-between">
                    <span class="grid h-12 w-12 place-items-center rounded-xl text-xl {{ $accent }}">{{ $icon }}</span>
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Active</span>
                </div>

                <h3 class="text-lg font-bold text-[#072f68]">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>
                <a href="{{ route($routeName) }}" class="mt-5 block w-full rounded-lg bg-[#072f68] px-4 py-2 text-center text-sm font-semibold text-white hover:bg-blue-900">Manage</a>
            </article>
        @endforeach

        @foreach ([
            ['Word of the Day','Publish a typed devotion, poster or audio message.','◉','bg-lime-100 text-lime-700'],
            ['Gallery','Organize church photos and ministry albums.','▧','bg-purple-100 text-purple-700'],
            ['Prayer Requests','Review and respond to submitted prayer requests.','♡','bg-pink-100 text-pink-700'],
            ['Website Settings','Update contacts, service times and social links.','⚙','bg-amber-100 text-amber-700'],
        ] as [$title,$description,$icon,$accent])
            <article class="rounded-2xl border bg-white p-5 shadow-sm">
                <div class="mb-4 flex justify-between">
                    <span class="grid h-12 w-12 place-items-center rounded-xl text-xl {{ $accent }}">{{ $icon }}</span>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">Coming next</span>
                </div>

                <h3 class="text-lg font-bold text-[#072f68]">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>
                <button disabled class="mt-5 w-full cursor-not-allowed rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">Manage</button>
            </article>
        @endforeach
    </section>
</x-admin-layout>
