<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_hundred',
        'has_won_main',
        'has_won_hundred',
        'payment_method'
    ];
}
