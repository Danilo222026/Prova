<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    //
    protected $table = 'empresa';
    protected $fillable = ['nome','logo'];
    public $timestamps = false;
    
    public function publicacoes(){
        return $this->hasMany(Publicacao::class);
    }
}
