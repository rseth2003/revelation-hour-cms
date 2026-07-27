<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleRouteAccessMiddleware
{
    private const ROUTE_MODULES = [
        'admin.settings.' => 'website',
        'admin.about-settings.' => 'website',
        'admin.core-values.' => 'website',
        'admin.service-times.' => 'website',
        'admin.hero-slides.' => 'media',
        'admin.daily-words.' => 'media',
        'admin.sermons.' => 'media',
        'admin.gallery.' => 'media',
        'admin.livestreams.' => 'media',
        'admin.events.' => 'events',
        'admin.event-registrations.' => 'events',
        'admin.library-resources.' => 'library',
        'admin.library-categories.' => 'library',
        'admin.members.' => 'membership',
        'admin.attendance.' => 'attendance',
        'admin.campuses.' => 'church_structure',
        'admin.ministries.' => 'church_structure',
        'admin.leaders.' => 'church_structure',
        'admin.prayer-requests.' => 'prayer',
        'admin.giving-methods.' => 'giving',
        'admin.communication.' => 'communication',
        'admin.analytics.' => 'analytics',
        'admin.users.' => 'users',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()?->getName();
        $user = $request->user();

        if (! $routeName || ! str_starts_with($routeName, 'admin.') || ! $user) {
            return $next($request);
        }

        foreach (self::ROUTE_MODULES as $prefix => $module) {
            if (str_starts_with($routeName, $prefix) && ! $user->canAccessModule($module)) {
                abort(403, 'You do not have access to this CMS module.');
            }
        }

        return $next($request);
    }
}
