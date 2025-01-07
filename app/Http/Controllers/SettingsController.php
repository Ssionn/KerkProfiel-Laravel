<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('settings.index');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            "username" => ["required", "string"],
            "email" => ["required", "string", "email"]
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->route('settings')->with('toast', [
            'message' => "Gebruikersinformatie is succesvol bijgewerkt",
            'type' => 'success'
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()->route('settings')->with('toast', [
                'message' => 'Wachtwoord komt niet over een met het huidige wachtwoord',
                'type' => 'error'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('settings')->with('toast', [
            'message' => 'Wachtwoord is successvol bijgewerkt',
            'type' => 'success'
        ]);
    }

    public function deleteAccount(Request $request): RedirectResponse
    {
        Auth::user()->delete();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('login');
    }
}
