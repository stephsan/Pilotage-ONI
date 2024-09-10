<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistreAbsent extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function absent(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
