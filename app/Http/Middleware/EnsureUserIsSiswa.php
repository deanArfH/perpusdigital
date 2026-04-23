<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSiswa
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isSiswa()) {
            if ($request->user() && $request->user()->isAdmin()) {
                return redirect('/admin');
            }
            return redirect('/');
        }

        return $next($request);
    }
}
