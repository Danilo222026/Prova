<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// SUBSTITUA as rotas de login padrão pelas suas
Route::middleware('guest')->group(function () {
    // Remove as rotas padrão de login que exigem email
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Use suas rotas customizadas se necessário, mas já temos no web.php
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});