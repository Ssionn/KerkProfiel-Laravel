<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as ContractsUser;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    const GOOGLE = 'google';

    public function redirect(): RedirectResponse
    {
        return Socialite::driver(self::GOOGLE)->redirect();
    }

    public function socialiteUser(): ContractsUser
    {
        return Socialite::driver(self::GOOGLE)->user();
    }

    public function updateUser(): RedirectResponse
    {
        $socialiteUser = $this->socialiteUser();

        $user = User::where([
            'provider' => self::GOOGLE,
            'provider_id' => $socialiteUser->id,
        ])->first();

        if (!$user) {
            $dbUser = User::where('email', $socialiteUser->getEmail())->first();

            if (!$dbUser) {
                $dbUser = User::create([
                    'username' => $socialiteUser->getName(),
                    'email' => $socialiteUser->getEmail(),
                    'provider' => self::GOOGLE,
                    'provider_id' => $socialiteUser->id,
                    'provider_token' => $socialiteUser->token,
                    'email_verified_at' => now(),
                ]);

                $user->assignRole('admin');

                Auth::login($dbUser);
                return redirect()->route('dashboard');
            }

            $dbUser->update([
                'provider' => self::GOOGLE,
                'provider_id' => $socialiteUser->id,
                'provider_token' => $socialiteUser->token,
            ]);

            Auth::login($dbUser);
            return redirect()->route('dashboard');
        }

        $user->update([
            'provider' => self::GOOGLE,
            'provider_id' => $socialiteUser->id,
            'provider_token' => $socialiteUser->token,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
