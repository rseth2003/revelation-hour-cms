<x-admin-layout title="RHMI CMS Dashboard" heading="Dashboard">
    <section class="mb-8 rounded-2xl bg-gradient-to-r from-[#072f68] to-[#0d5fa8] p-6 text-white shadow-lg">
        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-lime-300">Welcome back</p>
        <h2 class="mt-2 text-3xl font-bold">{{ auth()->user()->name }}</h2>
        <p class="mt-2 max-w-2xl text-blue-100">
            Manage every completed website module and track what we are building next.
        </p>
    </section>

    <div class="mb-5">
        <h2 class="text-xl font-bold text-[#072f68]">Completed Modules</h2>
        <p class="text-sm text-slate-500">These modules are active and connected to the public website.</p>
    </div>

    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach([
            ['Word of the Day','Scripture, devotion, poster and audio messages.','◉','admin.daily-words.index','bg-lime-100 text-lime-700'],
            ['Live Events','Event posters and homepage event slides.','▣','admin.events.index','bg-blue-100 text-blue-700'],
            ['Campuses','Locations, resident pastors and campus details.','⌂','admin.campuses.index','bg-cyan-100 text-cyan-700'],
            ['Ministries','Ministry pages, leaders, schedules and images.','◆','admin.ministries.index','bg-purple-100 text-purple-700'],
            ['Sermons','Video, audio, notes and featured messages.','▶','admin.sermons.index','bg-red-100 text-red-700'],
            ['Gallery','Photo albums, multiple uploads and public galleries.','▧','admin.gallery.index','bg-indigo-100 text-indigo-700'],
            ['Prayer Requests','Private prayer inbox, statuses and prayer team notes.','♡','admin.prayer-requests.index','bg-pink-100 text-pink-700'],
        ] as [$title,$description,$icon,$routeName,$accent])
            <article class="rounded-2xl border border-blue-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex justify-between">
                    <span class="grid h-12 w-12 place-items-center rounded-xl text-xl {{ $accent }}">
                        {{ $icon }}
                    </span>

                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Active
                    </span>
                </div>

                <h3 class="text-lg font-bold text-[#072f68]">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>

                <a href="{{ route($routeName) }}"
                   class="mt-5 block w-full rounded-lg bg-[#072f68] px-4 py-2 text-center text-sm font-semibold text-white hover:bg-blue-900">
                    Manage
                </a>
            </article>
        @endforeach
    </section>

    <div class="mb-5 mt-10">
        <h2 class="text-xl font-bold text-[#072f68]">Coming Soon</h2>
        <p class="text-sm text-slate-500">These are the next planned CMS modules.</p>
    </div>

    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach([
            ['Website Settings','Contacts, social links, service times and branding.','⚙','bg-amber-100 text-amber-700'],
            ['Hero Slider Manager','Manage custom homepage slides and campaigns.','▤','bg-sky-100 text-sky-700'],
            ['Members','Visitor and member records with consent controls.','♟','bg-slate-200 text-slate-700'],
            ['Users and Roles','Senior Usher, Pastor, Media Team and Admin permissions.','♜','bg-orange-100 text-orange-700'],
            ['Communication Center','SMS, email and scheduled event reminders.','✉','bg-emerald-100 text-emerald-700'],
            ['Analytics','Website activity and CMS content statistics.','▥','bg-teal-100 text-teal-700'],
        ] as [$title,$description,$icon,$accent])
            <article class="rounded-2xl border bg-white p-5 shadow-sm">
                <div class="mb-4 flex justify-between">
                    <span class="grid h-12 w-12 place-items-center rounded-xl text-xl {{ $accent }}">
                        {{ $icon }}
                    </span>

                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                        Coming Soon
                    </span>
                </div>

                <h3 class="text-lg font-bold text-[#072f68]">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $description }}</p>

                <button disabled
                        class="mt-5 w-full cursor-not-allowed rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">
                    Not Available Yet
                </button>
            </article>
        @endforeach
    </section>
</x-admin-layout>
