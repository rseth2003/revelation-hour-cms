<x-admin-layout title="RHMI CMS Dashboard" heading="Dashboard">
    @php
        $userRole = \App\Models\User::ROLES[auth()->user()->role] ?? ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'administrator'));
        $modules = [
            ['Word of the Day', 'Publish scripture, devotion, posters and audio messages.', '◉', 'admin.daily-words.index', 'lime'],
            ['Events', 'Manage services, conferences, posters and registrations.', '▣', 'admin.events.index', 'blue'],
            ['Livestreams', 'Schedule live broadcasts and manage previous streams.', '●', 'admin.livestreams.index', 'red'],
            ['Sermons', 'Publish video, audio, notes and featured messages.', '▶', 'admin.sermons.index', 'violet'],
            ['Praise Reports', 'Publish testimonies and moderate encouragements.', '🙌', 'admin.praise-reports.index', 'emerald'],
            ['eLibrary', 'Manage books, documents, categories and access settings.', '▤', 'admin.library-resources.index', 'amber'],
            ['Gallery', 'Create albums and publish church photographs.', '▧', 'admin.gallery.index', 'indigo'],
            ['Give & Donations', 'Update MTN, Airtel and card-giving information.', '♡', 'admin.giving-methods.index', 'emerald'],
            ['Website Settings', 'Manage public contact details, links and site information.', '⚙', 'admin.settings.edit', 'slate'],
        ];
    @endphp

    <section class="admin-welcome-panel">
        <div>
            <p class="admin-eyebrow">RHMI Administration</p>
            <h2>Good to see you, {{ auth()->user()->name }}.</h2>
            <p>Manage the ministry website, church records and communication tools from one organised workspace.</p>
        </div>
        <div class="admin-role-card">
            <span>Signed in as</span>
            <strong>{{ $userRole }}</strong>
            <a href="{{ route('home') }}" target="_blank" rel="noopener">Open website ↗</a>
        </div>
    </section>

    <section class="admin-section-heading">
        <div>
            <p class="admin-eyebrow">Quick access</p>
            <h2>Website and media</h2>
            <p>Open the tools used most often to keep the public website current.</p>
        </div>
    </section>

    <section class="admin-module-grid">
        @foreach($modules as [$title, $description, $icon, $routeName, $tone])
            @if(($routeName !== 'admin.giving-methods.index' || auth()->user()->hasRole('super_admin','senior_pastor','admin')) && ($routeName !== 'admin.praise-reports.index' || auth()->user()->canAccessModule('praise_reports')))
                <a href="{{ route($routeName) }}" class="admin-module-card admin-tone-{{ $tone }}">
                    <span class="admin-module-icon">{{ $icon }}</span>
                    <span class="admin-module-status">Active</span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $description }}</p>
                    <span class="admin-module-action">Manage <span aria-hidden="true">→</span></span>
                </a>
            @endif
        @endforeach
    </section>

    <section class="admin-section-heading admin-section-heading-spaced">
        <div>
            <p class="admin-eyebrow">Church operations</p>
            <h2>People, attendance and communication</h2>
            <p>Continue with the operational dashboards available to your account.</p>
        </div>
    </section>

    <section class="admin-dashboard-widgets">
        @include('partials.member-dashboard-card')

        @if(auth()->user()->hasRole('super_admin','senior_pastor','admin'))
            @include('partials.users-dashboard-card')
        @endif

        @if(auth()->user()->hasRole('super_admin','senior_pastor','campus_pastor','admin','senior_usher','membership_officer'))
            @include('partials.attendance-dashboard-card')
        @endif

        @include('partials.communication-dashboard-card')
        @include('partials.analytics-dashboard-card')
        @include('partials.hero-slider-dashboard-card')
        @include('partials.settings-dashboard-card')
    </section>
</x-admin-layout>
