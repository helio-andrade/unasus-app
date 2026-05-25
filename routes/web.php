<?php

use App\Http\Controllers\AlunoImportController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('import.create')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/cadastro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/cadastro', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/upload', [AlunoImportController::class, 'create'])->name('import.create');
    Route::post('/upload', [AlunoImportController::class, 'store'])->name('import.store');
});
