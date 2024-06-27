<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetteQuittance extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function ccd(){
        return $this->belongsTo(CentreCollecte::class,'centre_collecte_id');
    }
    public function ctid(){
        return $this->belongsTo(CentreTraitement::class,'centre_traitement_id');
    }
    public function lot_de_formulaire()
    {
        return $this->hasOne(FormulaireRecu::class);
    }
    public function recette()
    {
        return $this->belongsTo(Recette::class,'quittance_recette_ass');
    }
}
