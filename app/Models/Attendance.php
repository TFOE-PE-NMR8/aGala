<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    function registrant(){
        return $this->belongsTo(Registrant::class);
    }

    function guest(){
        return $this->belongsTo(Guest::class);
    }
}
