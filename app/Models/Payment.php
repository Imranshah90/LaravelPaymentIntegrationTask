<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'reference',
        'payment_time',
        'payment_id',
        'user_id',
        'status'
    ];

    protected $dates = [
        'payment_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
