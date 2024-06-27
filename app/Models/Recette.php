<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function site_doperation(){
        return $this->belongsTo(centreCollecte::class, 'site_operation');
    }

}