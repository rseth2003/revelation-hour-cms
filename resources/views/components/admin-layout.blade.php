<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'RHMI CMS' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
@php
    $websiteOpen = request()->routeIs(
        'admin.daily-words.*',
        'admin.events.*',
        'admin.sermons.*',
        'admin.gallery.*',
        'admin.prayer-requests.*'
    );

    $churchOpen = request()->routeIs(
        'admin.campuses.*',
        'admin.ministries.*',
        'admin.members.*',
        'admin.attendance.*'
    );

    $administrationOpen = request()->routeIs('admin.users.*');
@endphp

<div class="min-h-screen lg:flex">
    <aside
        id="adminSidebar"
        class="admin-sidebar fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-[#1f2775] text-white shadow-2xl transition-transform duration-300 lg:static lg:translate-x-0"
    >
        <div class="flex h-20 shrink-0 items-center gap-3 border-b border-white/10 px-5">
            <img
                src="{{ asset('images/revelation-hour-logo.jpg') }}"
                alt="RHMI logo"
                class="h-14 w-20 rounded-lg bg-white object-contain p-1"
            >

            <div class="min-w-0">
                <p class="truncate text-lg font-bold">RHMI CMS</p>
                <p class="text-xs text-blue-100">Church Management</p>
            </div>
        </div>

        <nav class="admin-sidebar-scroll flex-1 overflow-y-auto px-3 py-3">
            <a
                href="{{ route('dashboard') }}"
                class="admin-nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
            >
                <span class="admin-nav-icon">▦</span>
                <span>Dashboard</span>
            </a>

            <div class="admin-nav-group" data-sidebar-group>
                <button
                    type="button"
                    class="admin-nav-group-button {{ $websiteOpen ? 'is-open' : '' }}"
                    data-sidebar-group-button
                    aria-expanded="{{ $websiteOpen ? 'true' : 'false' }}"
                >
                    <span class="flex min-w-0 items-center gap-3">
                        <span class="admin-nav-icon">🌐</span>
                        <span>Website</span>
                    </span>
                    <span class="admin-nav-chevron">⌄</span>
                </button>

                <div class="admin-nav-submenu {{ $websiteOpen ? 'is-open' : '' }}" data-sidebar-submenu>
                    <div class="admin-nav-submenu-inner">
                        <a href="{{ route('admin.daily-words.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.daily-words.*') ? 'is-active' : '' }}">Word of the Day</a>
                        <a href="{{ route('admin.hero-slides.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.hero-slides.*') ? 'is-active' : '' }}">Hero Slider</a>
                        <a href="{{ route('admin.events.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.events.*') ? 'is-active' : '' }}">Live Events</a>
                        <a href="{{ route('admin.event-registrations.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.event-registrations.*') ? 'is-active' : '' }}">Event Registrations</a>
                        <a href="{{ route('admin.sermons.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.sermons.*') ? 'is-active' : '' }}">Sermons</a>
                        <a href="{{ route('admin.gallery.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.gallery.*') ? 'is-active' : '' }}">Gallery</a>
                        <a href="{{ route('admin.prayer-requests.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.prayer-requests.*') ? 'is-active' : '' }}">Prayer Requests</a>
                        <a href="{{ route('admin.settings.edit') }}" class="admin-nav-sublink {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">Website Settings</a>
                    </div>
                </div>
            </div>

            <div class="admin-nav-group" data-sidebar-group>
                <button
                    type="button"
                    class="admin-nav-group-button {{ $churchOpen ? 'is-open' : '' }}"
                    data-sidebar-group-button
                    aria-expanded="{{ $churchOpen ? 'true' : 'false' }}"
                >
                    <span class="flex min-w-0 items-center gap-3">
                        <span class="admin-nav-icon">⛪</span>
                        <span>Church</span>
                    </span>
                    <span class="admin-nav-chevron">⌄</span>
                </button>

                <div class="admin-nav-submenu {{ $churchOpen ? 'is-open' : '' }}" data-sidebar-submenu>
                    <div class="admin-nav-submenu-inner">
                        <a href="{{ route('admin.campuses.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.campuses.*') ? 'is-active' : '' }}">Campuses</a>
                        <a href="{{ route('admin.ministries.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.ministries.*') ? 'is-active' : '' }}">Ministries</a>
                        <a href="{{ route('admin.members.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.members.*') ? 'is-active' : '' }}">Members</a>

                        @if(auth()->user()->hasRole('super_admin','senior_pastor','campus_pastor','admin','senior_usher','membership_officer'))
                            <a href="{{ route('admin.attendance.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.attendance.*') ? 'is-active' : '' }}">Attendance</a>
                        @endif
                    </div>
                </div>
            </div>

            @if(auth()->user()->hasRole('super_admin','senior_pastor','admin'))
                <div class="admin-nav-group" data-sidebar-group>
                    <button
                        type="button"
                        class="admin-nav-group-button {{ $administrationOpen ? 'is-open' : '' }}"
                        data-sidebar-group-button
                        aria-expanded="{{ $administrationOpen ? 'true' : 'false' }}"
                    >
                        <span class="flex min-w-0 items-center gap-3">
                            <span class="admin-nav-icon">👥</span>
                            <span>Administration</span>
                        </span>
                        <span class="admin-nav-chevron">⌄</span>
                    </button>

                    <div class="admin-nav-submenu {{ $administrationOpen ? 'is-open' : '' }}" data-sidebar-submenu>
                        <div class="admin-nav-submenu-inner">
                            <a href="{{ route('admin.users.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">Users and Roles</a>
                            <a href="#" class="admin-nav-sublink opacity-70">Backups</a>
                            <a href="#" class="admin-nav-sublink opacity-70">System Logs</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="admin-nav-group" data-sidebar-group>
                <button type="button" class="admin-nav-group-button" data-sidebar-group-button aria-expanded="false">
                    <span class="flex min-w-0 items-center gap-3">
                        <span class="admin-nav-icon">📊</span>
                        <span>Reports</span>
                    </span>
                    <span class="admin-nav-chevron">⌄</span>
                </button>

                <div class="admin-nav-submenu" data-sidebar-submenu>
                    <div class="admin-nav-submenu-inner">
                        <a href="{{ route('admin.attendance.index') }}" class="admin-nav-sublink">Attendance Reports</a>
                        <a href="{{ route('admin.members.index') }}" class="admin-nav-sublink">Membership Reports</a>
                        <a href="{{ route('admin.prayer-requests.index') }}" class="admin-nav-sublink">Prayer Reports</a>
                        <a href="{{ route('admin.analytics.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.analytics.*') ? 'is-active' : '' }}">Analytics Dashboard</a>
                    </div>
                </div>
            </div>

            <div class="admin-nav-group" data-sidebar-group>
                <button type="button" class="admin-nav-group-button" data-sidebar-group-button aria-expanded="false">
                    <span class="flex min-w-0 items-center gap-3">
                        <span class="admin-nav-icon">✉</span>
                        <span>Communication</span>
                    </span>
                    <span class="admin-nav-chevron">⌄</span>
                </button>

                <div class="admin-nav-submenu" data-sidebar-submenu>
                    <div class="admin-nav-submenu-inner">
                        <a href="{{ route('admin.communication.index') }}" class="admin-nav-sublink {{ request()->routeIs('admin.communication.index','admin.communication.show') ? 'is-active' : '' }}">Message Center</a>
                        <a href="{{ route('admin.communication.create') }}" class="admin-nav-sublink {{ request()->routeIs('admin.communication.create') ? 'is-active' : '' }}">Compose Message</a>
                        <a href="{{ route('admin.communication.templates') }}" class="admin-nav-sublink {{ request()->routeIs('admin.communication.templates*') ? 'is-active' : '' }}">Templates</a>
                    </div>
                </div>
            </div>

            <div class="admin-nav-group" data-sidebar-group>
                <button type="button" class="admin-nav-group-button" data-sidebar-group-button aria-expanded="false">
                    <span class="flex min-w-0 items-center gap-3">
                        <span class="admin-nav-icon">⚙</span>
                        <span>Settings</span>
                    </span>
                    <span class="admin-nav-chevron">⌄</span>
                </button>

                <div class="admin-nav-submenu" data-sidebar-submenu>
                    <div class="admin-nav-submenu-inner">
                        <a href="{{ route('admin.settings.edit') }}" class="admin-nav-sublink {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">Website Settings</a>
                        <a href="#" class="admin-nav-sublink opacity-70">General Settings</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="shrink-0 border-t border-white/10 bg-[#1f2775] p-3">
            <a
                href="{{ route('home') }}"
                target="_blank"
                class="flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm font-semibold transition hover:bg-white/10"
            >
                <span>🌍</span>
                <span>View Public Website</span>
            </a>
        </div>
    </aside>

    <div id="adminSidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-950/50 lg:hidden"></div>

    <div class="min-w-0 flex-1">
        <header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b bg-white px-4 shadow-sm sm:px-6">
            <div class="flex items-center gap-3">
                <button
                    id="sidebarToggle"
                    type="button"
                    class="rounded-lg border border-slate-300 px-3 py-2 lg:hidden"
                    aria-label="Open CMS navigation"
                >
                    ☰
                </button>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[.2em] text-lime-600">Revelation Hour</p>
                    <h1 class="text-lg font-bold text-[#072f68]">{{ $heading ?? 'Dashboard' }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">
                        {{ \App\Models\User::ROLES[auth()->user()->role] ?? ucfirst(str_replace('_',' ',auth()->user()->role ?? 'administrator')) }}
                    </p>
                </div>

                <a href="{{ route('profile.edit') }}" class="rounded-lg border px-3 py-2 text-sm">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-lg bg-[#1f2775] px-3 py-2 text-sm font-semibold text-white">Logout</button>
                </form>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>
</div>

@include('partials.flash-toast')

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('adminSidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('adminSidebarOverlay');

    const openSidebar = () => {
        sidebar?.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    const closeSidebar = () => {
        sidebar?.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    toggle?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);

    document.querySelectorAll('[data-sidebar-group-button]').forEach((button) => {
        button.addEventListener('click', () => {
            const group = button.closest('[data-sidebar-group]');
            const submenu = group?.querySelector('[data-sidebar-submenu]');
            const isOpen = button.classList.toggle('is-open');

            submenu?.classList.toggle('is-open', isOpen);
            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    });
});
</script>
</body>
</html>
