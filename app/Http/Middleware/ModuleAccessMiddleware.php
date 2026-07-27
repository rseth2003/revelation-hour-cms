<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleAccessMiddleware
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active || ! $user->canAccessModule($module)) {
            abort(403, 'You do not have access to this CMS module.');
        }

        return $next($request);
    }
}
