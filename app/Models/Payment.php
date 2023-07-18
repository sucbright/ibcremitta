<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'payment_reference',
        'amount',
        'charged_amount',
        'first_name',
        'last_name',
        'email',
        'purpose',
        'payment_status',
    ];
}
