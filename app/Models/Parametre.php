<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;
protected $guarded=[];
    public function valeurs(){
        return $this->hasMany(Valeur::class);
    }
}
