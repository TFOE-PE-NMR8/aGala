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
        $this->hasMany(Guest::class);
    }

    public function registration(){
        $this->hasOne(Registration::class);
    }
}
