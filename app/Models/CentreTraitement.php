<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentreTraitement extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function region(){
        return $this->belongsTo(Valeur::class);
    }
    public function antenne(){
        return $this->belongsTo(Antenne::class);
    }
    public function ccds(){
        return $this->hasMany(CentreCollecte::class);
    }
    public function formulaires(){
        return $this->hasMany(Formulaire::class,'centre_traitement_id');
    }
    public function recette_quittances(){
        return $this->hasMany(RecetteQuittance::class);
    }
    public function formulaire_recus(){
        return $this->hasMany(FormulaireRecu::class,'centre_traitement_id');
    }
}
