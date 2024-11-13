<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $ability = null): Response
    {
        if (! $ability) {
            return redirect()->route('teams')->with('toast', 'Permission not specified.');
        }

        if (! auth()->user()->hasPermission($ability)) {
            return redirect()->route('teams')->with('toast', 'You do not have the permission to do this.');
        }

        return $next($request);
    }
}
