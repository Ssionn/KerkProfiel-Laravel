<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\TeamsController;
use App\Services\ImageHolder;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/sign-up', [RegisterController::class, 'index'])->name('register');
Route::post('/sign-up', [RegisterController::class, 'register'])->name('register.register');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');

    Route::prefix('teams')->group(function () {
        Route::get('/', [TeamsController::class, 'index'])->name('teams');
        Route::middleware('permissionCheck:create team')->group(function () {
            Route::get('/create', [TeamsController::class, 'create'])
                ->name('teams.create');
            Route::post('/create', [TeamsController::class, 'store'])
                ->name('teams.store');
        });
        Route::post('uploads/process', [ImageHolder::class, 'store']);
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/auth/google/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'updateUser']);
