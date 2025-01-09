<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SurveysController;
use App\Http\Controllers\TeamsController;
use App\Services\ImageHolderService;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('teams')->group(function () {
        Route::get('/', [TeamsController::class, 'index'])->name('teams');
        Route::post('/invite', [InvitationController::class, 'sendInvite'])->name('teams.invite');
        Route::post('/create/survey', [TeamsController::class, 'createSurvey'])->name('teams.create.survey');

        Route::middleware(['PermissionCheck:create team', 'PermissionCheck:leave team'])->group(function () {
            Route::get('/create', [TeamsController::class, 'create'])
                ->name('teams.create');
            Route::post('/create', [TeamsController::class, 'store'])
                ->name('teams.store');

            Route::post('/leave/{user}', [TeamsController::class, 'leaveTeam'])
                ->name('teams.leave');
        });

        Route::delete('/{user}/remove', [TeamsController::class, 'destroy'])
            ->name('team.members.destroy');

        Route::post('uploads/process', [ImageHolderService::class, 'store']);
    });

    Route::prefix('surveys')->group(function () {
        Route::get('/', [SurveysController::class, 'index'])->name('surveys');
        Route::post('/', [SurveysController::class, 'store'])->name('surveys.store');

        Route::get('/{survey}', [SurveysController::class, 'showSurvey'])->name('surveys.show');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/auth/google/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'updateUser']);
