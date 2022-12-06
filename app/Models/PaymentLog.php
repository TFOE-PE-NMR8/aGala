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

    public function registration(){
        return $this->belongsTo(Registration::class, 'registration_id')->with('registrant');
    }

    public function agent(){
        return $this->belongsTo(User::class, 'paid_user_id');
    }
}
