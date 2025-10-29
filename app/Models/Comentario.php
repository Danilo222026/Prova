<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Publicacao; 

class Comentario extends Model
{
    protected $table = 'comentarios';
    protected $fillable = ['texto', 'publicacao_id'];
    public $timestamps = false;

    public function publicacao()
    {
        return $this->belongsTo(Publicacao::class, 'publicacao_id');
    }
}