<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Publicacao;

class ComentarioController extends Controller
{
    public function store(Request $request, $publicacaoId)
    {
        $request->validate([
            'texto' => 'required'
        ]);

        Comentario::create([
            'texto' => $request->texto,
            'publicacao_id' => $publicacaoId
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'texto' => 'required'
        ]);

        $comentario = Comentario::findOrFail($id);
        $comentario->update([
            'texto' => $request->texto
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return redirect()->back();
    }

    public function toggleComentarios($publicacaoId)
    {
        $sessionKey = "show_comentarios_{$publicacaoId}";
        session([$sessionKey => !session($sessionKey, false)]);
        
        return redirect()->back();
    }
}