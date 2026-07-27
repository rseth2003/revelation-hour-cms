<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active) {
            abort(403, 'You do not have permission to access this area.');
        }

        if ($user->role === 'super_admin' || in_array($user->role, $roles, true)) {
            return $next($request);
        }

        $module = $this->moduleForRoute($request->route()?->getName());
        if ($module && $user->canAccessModule($module)) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this area.');
    }

    private function moduleForRoute(?string $routeName): ?string
    {
        $map = [
            'admin.settings.' => 'website', 'admin.about-settings.' => 'website',
            'admin.core-values.' => 'website', 'admin.service-times.' => 'website',
            'admin.hero-slides.' => 'media', 'admin.daily-words.' => 'media',
            'admin.sermons.' => 'media', 'admin.gallery.' => 'media',
            'admin.livestreams.' => 'media', 'admin.events.' => 'events',
            'admin.event-registrations.' => 'events', 'admin.library-' => 'library',
            'admin.members.' => 'membership', 'admin.attendance.' => 'attendance',
            'admin.campuses.' => 'church_structure', 'admin.ministries.' => 'church_structure',
            'admin.leaders.' => 'church_structure', 'admin.prayer-requests.' => 'prayer',
            'admin.giving-methods.' => 'giving', 'admin.communication.' => 'communication',
            'admin.analytics.' => 'analytics', 'admin.users.' => 'users',
        ];

        foreach ($map as $prefix => $module) {
            if ($routeName && str_starts_with($routeName, $prefix)) {
                return $module;
            }
        }

        return null;
    }
}
