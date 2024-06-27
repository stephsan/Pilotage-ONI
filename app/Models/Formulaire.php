<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulaire extends Model
{
    protected $guarded=[];
    public function ctid(){
        return $this->belongsTo(CentreTraitement::class, 'centre_traitement_id');
    }
}
