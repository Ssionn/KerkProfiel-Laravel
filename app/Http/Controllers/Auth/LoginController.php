<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function index(): View|RedirectResponse
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $loginRequest): RedirectResponse
    {
        $credentials = $loginRequest->validated();

        if (Auth::attempt($credentials)) {
            $loginRequest->session()->regenerate();

            $user = $this->userRepository->findUserById(Auth::user()->id);

            $this->userRepository->makeUserActive($user->id);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = $this->userRepository->findUserById(Auth::user()->id);

        $this->userRepository->makeUserInactive($user->id);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
