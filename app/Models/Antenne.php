<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antenne extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function ctids(){
        return $this->hasMany(CentreTraitement::class);
    }
}
