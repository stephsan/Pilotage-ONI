<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valeur extends Model
{
    use HasFactory;
    protected $guarded=[];
        public function parametre(){
            return $this->belongsTo(Parametre::class);
        }
        public function ctids(){
            return $this->hasMany(CentreTraitement::class,'region_id');
        }
        public function antenne(){
                return $this->belongsTo(Antene::class,'antene_id');
            
        }
}

