<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmetFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'price',
        'doctor',
        'date',
        'time',
        'status',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
