<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'RHMI CMS' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
<div class="min-h-screen lg:flex">
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full bg-[#072f68] text-white transition-transform duration-200 lg:static lg:translate-x-0">
        <div class="flex h-20 items-center gap-3 border-b border-white/10 px-6">
            <img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="RHMI" class="h-14 w-20 rounded bg-white object-contain p-1">
            <div><p class="font-bold tracking-wide">RHMI CMS</p><p class="text-xs text-blue-100">Church Management</p></div>
        </div>

        <nav class="space-y-1 p-4 text-sm">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 font-semibold hover:bg-white/10 {{ request()->routeIs('dashboard') ? 'bg-white/15' : '' }}">
                <span>▦</span><span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-white/10"><span>◉</span><span>Word of the Day</span></a>
            <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-white/10 {{ request()->routeIs('admin.events.*') ? 'bg-white/15' : '' }}">
                <span>▣</span><span>Live Events</span>
            </a>
            <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-white/10"><span>▶</span><span>Sermons</span></a>
            <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-white/10"><span>▧</span><span>Gallery</span></a>
            <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-white/10"><span>♡</span><span>Prayer Requests</span></a>
            <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-white/10"><span>⚙</span><span>Website Settings</span></a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 border-t border-white/10 p-4">
            <a href="{{ route('home') }}" class="block rounded-lg border border-white/20 px-4 py-3 text-center text-sm hover:bg-white/10">View Public Website</a>
        </div>
    </aside>

    <div class="min-w-0 flex-1">
        <header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b bg-white px-4 shadow-sm sm:px-6">
            <div class="flex items-center gap-3">
                <button id="sidebarToggle" type="button" class="rounded-lg border px-3 py-2 lg:hidden" aria-label="Open menu">☰</button>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-600">Revelation Hour</p>
                    <h1 class="text-lg font-bold text-[#072f68]">{{ $heading ?? 'Dashboard' }}</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs capitalize text-slate-500">{{ str_replace('_', ' ', auth()->user()->role ?? 'administrator') }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="rounded-lg border px-3 py-2 text-sm hover:bg-slate-50">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg bg-[#072f68] px-3 py-2 text-sm font-semibold text-white hover:bg-blue-900">Logout</button>
                </form>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">{{ $slot }}</main>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if (toggle && sidebar) toggle.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
});
</script>
</body>
</html>
