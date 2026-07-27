<?php

return [
    'force_https' => env('FORCE_HTTPS', false),
    'hsts' => env('SECURITY_HSTS', false),
    'max_request_mb' => env('MAX_REQUEST_MB', 550),
    'csp_report_only' => env('CSP_REPORT_ONLY', false),

    // This policy keeps the current site working while limiting content to
    // trusted sources. Tighten it further when all inline scripts are removed.
    'development_content_security_policy' => implode(' ', [
        "default-src 'self' http://localhost:5173 http://127.0.0.1:5173;",
        "base-uri 'self';",
        "form-action 'self';",
        "frame-ancestors 'self';",
        "object-src 'none';",
        "img-src 'self' data: blob: http: https:;",
        "media-src 'self' blob: http: https:;",
        "font-src 'self' data: http: https:;",
        "style-src 'self' 'unsafe-inline' http://localhost:5173 http://127.0.0.1:5173;",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:5173 http://127.0.0.1:5173;",
        "connect-src 'self' ws://localhost:5173 ws://127.0.0.1:5173 http://localhost:5173 http://127.0.0.1:5173;",
        "frame-src 'self' https://www.youtube.com https://youtube.com https://www.facebook.com https://zoom.us https://meet.google.com;",
    ]),

    'content_security_policy' => env('CONTENT_SECURITY_POLICY', implode(' ', [
        "default-src 'self';",
        "base-uri 'self';",
        "form-action 'self';",
        "frame-ancestors 'self';",
        "object-src 'none';",
        "img-src 'self' data: blob: https:;",
        "media-src 'self' blob: https:;",
        "font-src 'self' data: https:;",
        "style-src 'self' 'unsafe-inline' https:;",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:;",
        "connect-src 'self' https:;",
        "frame-src 'self' https://www.youtube.com https://youtube.com https://www.facebook.com https://zoom.us https://meet.google.com;",
        "upgrade-insecure-requests;",
    ])),
];
