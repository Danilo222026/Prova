<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class home extends Model
{

    public $timestamps = false;
    
    public function publicacoes(){
        return $this->hasMany(Publicacao::class);
    }
}
