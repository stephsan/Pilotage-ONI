<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testlin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function antenne()
    {
        return $this->belongsTo(Antenne::class, 'antenne_id');
    }
}
