<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'ageRange',
        'insurance',
        'medication',
        'medicationName',
        'medicalHistory',
        'otherCondition',
        'contactMethod',
        'phone',
        'email',
        'address',
        'emergencyContact'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'medicalHistory' => 'array',
    ];

}
