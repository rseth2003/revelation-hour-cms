<x-admin-layout>
@php
    $maxMonthly = max(1, collect($monthlyGrowth)->max('total') ?? 1);
    $maxCampus = max(1, collect($campusGrowth)->max('total') ?? 1);
    $maxMinistry = max(1, collect($ministryGrowth)->max('total') ?? 1);
@endphp

<div class="mb-8 flex flex-wrap items-start justify-between gap-4">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[.2em] text-lime-600">Church Intelligence</p>
        <h1 class="text-3xl font-bold text-[#072f68]">Analytics Dashboard</h1>
        <p class="mt-2 text-slate-600">A live overview of membership, ministry activity, events and communication records.</p>
    </div>
    <div class="rounded-xl border bg-white px-4 py-3 text-sm text-slate-500 shadow-sm">
        Updated {{ now()->format('d M Y, H:i') }}
    </div>
</div>

<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
@foreach([
    ['Total Members',$memberCount,'👥','All registered people'],
    ['Active Members',$activeMembers,'✓','Currently active'],
    ['New This Month',$newThisMonth,'↗','Added this month'],
    ['Visitors',$visitors,'◎','Visitor records'],
    ['Campuses',$campusCount,'⌂','Church locations'],
    ['Ministries',$ministryCount,'◆','Active ministry records'],
    ['Upcoming Events',$upcomingEvents,'◷','Events still ahead'],
    ['Prayer Requests',$prayerRequests,'🙏','Recorded requests'],
] as [$label,$value,$icon,$description])
<article class="rounded-2xl border bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-slate-500">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-[#072f68]">{{ number_format($value) }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ $description }}</p>
        </div>
        <span class="grid h-11 w-11 place-items-center rounded-xl bg-slate-100 text-lg">{{ $icon }}</span>
    </div>
</article>
@endforeach
</section>

<section class="mt-8 grid gap-6 xl:grid-cols-[1.3fr_.7fr]">
    <article class="rounded-2xl border bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[#072f68]">Member growth</h2>
                <p class="mt-1 text-sm text-slate-500">New member records over the last six months.</p>
            </div>
            <span class="rounded-full bg-lime-50 px-3 py-1 text-xs font-semibold text-lime-700">{{ $newThisYear }} this year</span>
        </div>

        <div class="mt-8 flex h-64 items-end gap-4 border-b border-l border-slate-200 px-4 pb-3">
            @forelse($monthlyGrowth as $month)
                @php $height = max(8, round(($month['total'] / $maxMonthly) * 190)); @endphp
                <div class="flex min-w-0 flex-1 flex-col items-center justify-end">
                    <span class="mb-2 text-xs font-bold text-[#072f68]">{{ $month['total'] }}</span>
                    <div class="w-full max-w-16 rounded-t-xl bg-[#072f68]" style="height: {{ $height }}px"></div>
                    <span class="mt-3 text-xs font-semibold text-slate-500">{{ $month['label'] }}</span>
                </div>
            @empty
                <p class="m-auto text-sm text-slate-500">No growth data available.</p>
            @endforelse
        </div>
    </article>

    <article class="rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-[#072f68]">Spiritual milestones</h2>
        <p class="mt-1 text-sm text-slate-500">Based on saved member records.</p>

        <div class="mt-6 space-y-5">
            @foreach([
                ['Baptized',$baptized,$memberCount],
                ['Born Again',$bornAgain,$memberCount],
                ['Active',$activeMembers,$memberCount],
            ] as [$label,$value,$total])
                @php $percent = $total > 0 ? round(($value / $total) * 100) : 0; @endphp
                <div>
                    <div class="mb-2 flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">{{ $label }}</span>
                        <span class="font-bold text-[#072f68]">{{ $value }} · {{ $percent }}%</span>
                    </div>
                    <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-lime-500" style="width: {{ min(100,$percent) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 rounded-xl bg-slate-50 p-4">
            <p class="text-sm font-semibold text-slate-600">Communication readiness</p>
            <div class="mt-3 grid grid-cols-2 gap-3">
                <div><p class="text-2xl font-bold text-[#072f68]">{{ $communicationMessages }}</p><p class="text-xs text-slate-500">Messages</p></div>
                <div><p class="text-2xl font-bold text-[#072f68]">{{ $preparedRecipients }}</p><p class="text-xs text-slate-500">Recipients prepared</p></div>
            </div>
        </div>
    </article>
</section>

<section class="mt-8 grid gap-6 lg:grid-cols-2">
    <article class="rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-[#072f68]">Members by campus</h2>
        <p class="mt-1 text-sm text-slate-500">Largest registered campus communities.</p>
        <div class="mt-6 space-y-4">
            @forelse($campusGrowth as $item)
                @php $percent = round(($item['total'] / $maxCampus) * 100); @endphp
                <div>
                    <div class="mb-2 flex justify-between gap-4 text-sm">
                        <span class="truncate font-semibold text-slate-700">{{ $item['label'] }}</span>
                        <span class="font-bold text-[#072f68]">{{ $item['total'] }}</span>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-[#072f68]" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-sm text-slate-500">No campus membership data yet.</p>
            @endforelse
        </div>
    </article>

    <article class="rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-[#072f68]">Members by ministry</h2>
        <p class="mt-1 text-sm text-slate-500">Ministry participation from member records.</p>
        <div class="mt-6 space-y-4">
            @forelse($ministryGrowth as $item)
                @php $percent = round(($item['total'] / $maxMinistry) * 100); @endphp
                <div>
                    <div class="mb-2 flex justify-between gap-4 text-sm">
                        <span class="truncate font-semibold text-slate-700">{{ $item['label'] }}</span>
                        <span class="font-bold text-[#072f68]">{{ $item['total'] }}</span>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-emerald-500" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-sm text-slate-500">No ministry membership data yet.</p>
            @endforelse
        </div>
    </article>
</section>

<section class="mt-8 grid gap-6 xl:grid-cols-3">
    @foreach([
        ['Membership Types',$membershipTypes],
        ['Member Status',$membershipStatuses],
        ['Gender Distribution',$genderCounts],
    ] as [$title,$items])
    <article class="rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-[#072f68]">{{ $title }}</h2>
        <div class="mt-5 space-y-3">
            @forelse($items as $label=>$total)
                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                    <span class="text-sm font-semibold text-slate-600">{{ str($label)->replace('_',' ')->title() }}</span>
                    <span class="rounded-full bg-white px-3 py-1 text-sm font-bold text-[#072f68] shadow-sm">{{ $total }}</span>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-slate-500">No data available.</p>
            @endforelse
        </div>
    </article>
    @endforeach
</section>

<section class="mt-8 grid gap-6 lg:grid-cols-2">
    <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        <div class="border-b px-6 py-5">
            <h2 class="text-xl font-bold text-[#072f68]">Recent members</h2>
        </div>
        <div class="divide-y">
            @forelse($recentMembers as $member)
                <div class="flex items-center justify-between gap-4 px-6 py-4">
                    <div>
                        <p class="font-semibold text-slate-800">{{ trim($member->first_name.' '.$member->last_name) }}</p>
                        <p class="text-xs text-slate-500">{{ str($member->membership_type)->title() }} · {{ str($member->membership_status)->title() }}</p>
                    </div>
                    <span class="text-xs font-semibold text-slate-400">{{ \Carbon\Carbon::parse($member->created_at)->format('d M') }}</span>
                </div>
            @empty
                <p class="px-6 py-10 text-center text-sm text-slate-500">No member records.</p>
            @endforelse
        </div>
    </article>

    <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        <div class="border-b px-6 py-5">
            <h2 class="text-xl font-bold text-[#072f68]">Recent events</h2>
        </div>
        <div class="divide-y">
            @forelse($recentEvents as $event)
                <div class="flex items-center justify-between gap-4 px-6 py-4">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $event->title }}</p>
                        <p class="text-xs text-slate-500">{{ $event->location ?: 'Location not set' }}</p>
                    </div>
                    <span class="text-xs font-semibold text-slate-500">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                </div>
            @empty
                <p class="px-6 py-10 text-center text-sm text-slate-500">No event records.</p>
            @endforelse
        </div>
    </article>
</section>
@include('partials.attendance-analytics')
</x-admin-layout>
