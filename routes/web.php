<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\TeamsController;
use App\Services\ImageHolder;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/sign-up', [RegisterController::class, 'index'])->name('register');
    Route::post('/sign-up', [RegisterController::class, 'register'])->name('register.register');
});

Route::get('/invite/register/{token}', [InvitationController::class, 'acceptInvite'])
    ->name('teams.accept');
Route::post('/invite/register/{token}', [InvitationController::class, 'acceptInvitePost'])
    ->name('teams.acceptPost');

Route::get('/invite/login/{token}', [InvitationController::class, 'acceptInviteLogin'])
    ->name('teams.acceptLogin');
Route::post('/invite/login/{token}', [InvitationController::class, 'acceptInviteLoginPost'])
    ->name('teams.acceptPostLogin');


Route::middleware('auth', 'UserActivityCheck')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');

    Route::prefix('teams')->group(function () {
        Route::get('/', [TeamsController::class, 'index'])->name('teams');
        Route::post('/invite', [InvitationController::class, 'sendInvite'])->name('teams.invite');

        Route::middleware('PermissionCheck:create team')->group(function () {
            Route::get('/create', [TeamsController::class, 'create'])
                ->name('teams.create');
            Route::post('/create', [TeamsController::class, 'store'])
                ->name('teams.store');
        });

        Route::middleware('PermissionCheck:leave team')->group(function () {
            Route::post('/leave/{user}', [TeamsController::class, 'leaveTeam'])
                ->name('teams.leave');
        });

        Route::delete('/{user}/remove', [TeamsController::class, 'destroy'])
            ->name('team.members.destroy');

        Route::post('uploads/process', [ImageHolder::class, 'store']);
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings');
        Route::post('/profile/update', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
        Route::post('/password/update', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
        Route::post('/account/delete', [SettingsController::class, 'deleteAccount'])->name('settings.account.delete');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/auth/google/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'updateUser']);
