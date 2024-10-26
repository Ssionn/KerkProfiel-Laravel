<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequiresTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->team_id && !$request->routeIs(['teams.create', 'teams.store'])) {
            return redirect()->route('teams.create')
                ->with('info', 'Please create or join a team first.');
        }

        return $next($request);
    }
}
