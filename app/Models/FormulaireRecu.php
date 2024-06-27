<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaireRecu extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function ccd(){
        return $this->belongsTo(CentreCollecte::class,'centre_collecte_id');
    }
    public function ctid(){
        return $this->belongsTo(CentreTraitement::class, 'centre_traitement_id');
    }
    public function quittance()
    {
        return $this->hasOne(RecetteQuittance::class,'formulaire_recus_id');
    }
}
