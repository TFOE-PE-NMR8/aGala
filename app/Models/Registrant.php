<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    public function guests(){
        return $this->hasMany(Guest::class);
    }

    public function registration(){
       return $this->hasOne(Registration::class);
    }
}
