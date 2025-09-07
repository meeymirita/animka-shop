<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return Inertia::render('Index');
});
Route::get('/second', [PageController::class, 'second'])->name('second');
Route::get('/', [PageController::class, 'index'])->name('index');

// форма логина
Route::get('/login-form', [LoginController::class, 'showLoginForm'])->name('login-form');
// обработка логина
Route::post('/login', [LoginController::class, 'login'])->name('login');
// форма регистрации
Route::get('/register-form', [LoginController::class, 'showRegisterForm'])->name('register-form');
// регистрация
Route::post('/register', [LoginController::class, 'register'])->name('register');
// Показ формы  забыл пароль из доки
Route::get('/forgot-password-show', [LoginController::class, 'forgotPasswordShowForm'])
    ->name('forgot-password-show')
    ->middleware('guest:alter');
//guest:alter мой тут config/auth.php
// Обработка запроса
Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])
    ->name('forgot-password')
    ->middleware('guest:alter');
// Показ формы сброса
Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])
    ->middleware('guest:alter');

// Обработка пароля
Route::post('/reset-password', [LoginController::class, 'resetPassword'])
    ->middleware('guest:alter');
// Показ формы сброса без токена
Route::get('/reset-password', [LoginController::class, 'showResetPasswordForm'])
    ->middleware('guest:alter')
    ->name('password.reset');



// me аксиос на главную чтоб проверить данные юзера
Route::get('/me', function () {
    return response()->json([
        'auth' => Auth::guard('alter')->check(),
        'user' => Auth::guard('alter')->user(),
    ]);
});

