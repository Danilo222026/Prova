<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comentario; 

class publicacao extends Model
{
    //
    protected $table = 'publicacao';
    protected $fillable = ['foto','titulo_prato','local','cidade','empresa_id',"likes","dislikes"];
    public $timestamps = false;

    public function empresa() {
            return $this->belongsTo(Empresa::class,'empresa_id');                      
        }
        
    public function comentarios(){
        return $this->hasMany(Comentario::class, 'publicacao_id');
    }
}
