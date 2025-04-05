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
            return redirect()->back()->with(
                'toast',
                [
                    'message' => 'You don\'t have the ability to do this.',
                    'type' => 'error',
                ]
            );
        }

        if (! auth()->user()->hasPermission($ability)) {
            return redirect()->back()->with(
                'toast',
                [
                    'message' => 'You don\'t have the permission to do this.',
                    'type' => 'error',
                ]
            );
        }

        return $next($request);
    }
}
