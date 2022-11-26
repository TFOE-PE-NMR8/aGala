<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    public function registrant(){
        return $this->belongsTo(Registrant::class, 'registrant_id')->with("guests");
    }

    public function payments(){
        return $this->hasMany(PaymentLog::class);
    }
}
