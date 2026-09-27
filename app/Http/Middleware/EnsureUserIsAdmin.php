<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * This runs after the 'auth' middleware, so we already know a user is
     * logged in — this only checks *which* role they have. Kept separate
     * from 'auth' deliberately: once customer accounts exist, being logged
     * in will no longer imply being allowed into /admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            abort(403, 'دسترسی غیرمجاز.');
        }

        return $next($request);
    }
}
