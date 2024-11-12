<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    const GOOGLE = 'google';

    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function redirect()
    {
        return Socialite::driver(self::GOOGLE)->redirect();
    }

    public function socialiteUser()
    {
        return Socialite::driver(self::GOOGLE)->user();
    }

    public function updateUser()
    {
        $socialiteUser = $this->socialiteUser();

        $user = User::where([
            'provider' => self::GOOGLE,
            'provider_id' => $socialiteUser->id,
        ])->first();

        if (! $user) {
            $dbUser = User::where('email', $socialiteUser->getEmail())->first();

            if (! $dbUser) {
                $dbUser = User::create([
                    'username' => $socialiteUser->getName(),
                    'email' => $socialiteUser->getEmail(),
                    'provider' => self::GOOGLE,
                    'provider_id' => $socialiteUser->id,
                    'provider_token' => $socialiteUser->token,
                    'email_verified_at' => now(),
                    'role_id' => 4,
                    'team_id' => null,
                ]);

                $this->userRepository->makeUserActive($dbUser->id);

                Auth::login($dbUser);

                return redirect()->route('dashboard');
            }

            $dbUser->update([
                'provider' => self::GOOGLE,
                'provider_id' => $socialiteUser->id,
                'provider_token' => $socialiteUser->token,
            ]);

            $this->userRepository->makeUserActive($dbUser->id);

            Auth::login($dbUser);

            return redirect()->route('dashboard');
        }

        $user->update([
            'provider' => self::GOOGLE,
            'provider_id' => $socialiteUser->id,
            'provider_token' => $socialiteUser->token,
        ]);

        $this->userRepository->makeUserActive($user->id);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
