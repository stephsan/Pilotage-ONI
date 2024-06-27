<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotCentre extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='centre_collecte_centre_traitement';
}
