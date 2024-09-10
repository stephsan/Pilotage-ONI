<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registre extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function registre_absents(){
        return $this->hasMany(RegistreAbsent::class);
    }
}
