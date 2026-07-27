<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RejectOversizedRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        $limitMb = (int) config('security.max_request_mb', 550);
        $contentLength = (int) $request->server('CONTENT_LENGTH', 0);

        if ($contentLength > ($limitMb * 1024 * 1024)) {
            abort(413, 'The submitted request is too large.');
        }

        return $next($request);
    }
}
