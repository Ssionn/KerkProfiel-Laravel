<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function index(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $registerRequest)
    {
        $credentials = $registerRequest->validated();

        if (! $credentials) {
            return back()->withErrors([
                'registration_failed' => 'Iets ging verkeerd, probeer het later opnieuw',
            ]);
        }

        $user = $this->userRepository->createUser(
            $registerRequest->username,
            $registerRequest->email,
            $registerRequest->password
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
