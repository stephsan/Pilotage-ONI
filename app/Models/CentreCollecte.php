<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentreCollecte extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function parametre(){
        return $this->belongsTo(Parametre::class);
    }
    public function commune(){
        return $this->belongsTo(Valeur::class);
    }
    public function CTID(){
        return $this->belongsTo(CentreTraitement::class, 'centre_traitement_id');
    }
    public function recette_quittances(){
        return $this->hasMany(RecetteQuittance::class,'centre_collecte_id');
    }
    public function formulaire_recus(){
        return $this->hasMany(FormulaireRecu::class,'centre_collecte_id');
    }

}
