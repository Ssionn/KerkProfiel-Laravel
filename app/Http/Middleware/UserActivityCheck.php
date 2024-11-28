<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserActivityCheck
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $session = DB::table('sessions')->where('user_id', auth()->user()->id)->first();

        $this->userRepository->makeUserActive($session->user_id);

        return $next($request);
    }
}
