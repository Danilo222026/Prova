<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\Publicacao;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        
        $publicacoes = Publicacao::with(['empresa', 'comentarios'])->get();
        $totalLikes = Publicacao::sum('likes');
        $totalDislikes = Publicacao::sum('dislikes');
        
        return view('home', compact('publicacoes', 'totalLikes', 'totalDislikes'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}