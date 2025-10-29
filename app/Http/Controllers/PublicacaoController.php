<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacao;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;

class PublicacaoController extends Controller
{
   
    public function index()
    {
        $publicacoes = Publicacao::all();
        return view('home', compact('publicacoes'));
    }

   public function like($id)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }

        $publicacao = Publicacao::find($id);
        
        if ($publicacao) {
            $publicacao->likes = $publicacao->likes + 1;
            $publicacao->save();
            
            session(["liked_$id" => true]);
        }
        $publicacao = Publicacao::findOrFail($id);
    
        if (!session("liked_$id") && !session("disliked_$id")) {
        $publicacao->increment('likes');
        session(["liked_$id" => true]);
        }

        return redirect()->back();
    }

    public function dislike($id)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }

        $publicacao = Publicacao::find($id);
        
        if ($publicacao) {
            $publicacao->dislikes = $publicacao->dislikes + 1;
            $publicacao->save();
            
            session(["disliked_$id" => true]);
        }
        
        if (!session("disliked_$id") && !session("liked_$id")) {
        $publicacao->increment('dislikes');
        session(["disliked_$id" => true]);
        }    
        return redirect()->back();
    }

}
