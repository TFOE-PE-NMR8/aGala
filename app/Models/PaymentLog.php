<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'paid_user_id',
        'registration_id',
        'amount',
        'payment_method',
        'date'
    ];

    public function registrant(){
        return $this->belongsTo(Registrant::class);
    }

    public function registration(){
        return $this->belongsTo(Registration::class);
    }
}
