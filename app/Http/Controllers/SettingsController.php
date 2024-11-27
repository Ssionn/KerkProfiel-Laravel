<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $request->validate([
            "username" => ["required", "string"],
            "email" => ["required", "string", "email"]
        ]);

        $changes = array_filter([
            'username' => $request->username !== $user->username ? $request->username : null,
            'email' => $request->email !== $user->email ? $request->email : null,
        ]);

        if (!empty($changes)) {
            $user->update($changes);
            $message = count($changes) > 1
                ? 'Gebruikersnaam en e-mail zijn succesvol bijgewerkt.'
                : (isset($changes['username'])
                    ? 'Gebruikersnaam is succesvol bijgewerkt.'
                    : 'E-mail is succesvol bijgewerkt.');

            return redirect()->route("settings.index")->with('status', $message);
        }

        return redirect()->route("settings.index");
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        $user->update([
            "password" => Hash::make($request->get('password')),
        ]);

        return redirect()->route("settings.index")
            ->with('status', 'Wachtwoord is succesvol bijgewerkt.');
    }

    public function deleteAccount()
    {
        $user = Auth::user();
        $user->delete();

        return redirect('/');
    }
}
