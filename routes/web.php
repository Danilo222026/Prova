<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicacaoController;
use App\Http\Controllers\ComentarioController;
use App\Models\Publicacao;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/like/{id}', [PublicacaoController::class, 'like'])->name('like');
Route::post('/dislike/{id}', [PublicacaoController::class, 'dislike'])->name('dislike');

Route::post('/comentario/{publicacaoId}', [ComentarioController::class, 'store'])->name('comentario.store');
Route::put('/comentario/{id}', [ComentarioController::class, 'update'])->name('comentario.update');
Route::delete('/comentario/{id}', [ComentarioController::class, 'destroy'])->name('comentario.destroy');
Route::get('/comentarios/toggle/{publicacaoId}', [ComentarioController::class, 'toggleComentarios'])->name('comentarios.toggle');

Route::get('/dashboard', function () {
    $usuario = Auth::user();
    $publicacoes = Publicacao::with(['empresa', 'comentarios'])->get();
    $totalLikes = Publicacao::sum('likes');
    $totalDislikes = Publicacao::sum('dislikes');
    
    return view('dashboard', compact('usuario', 'publicacoes', 'totalLikes', 'totalDislikes'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});