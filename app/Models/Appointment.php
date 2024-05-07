<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'healthcare_id',
        'appointment_start_time',
        'appointment_end_time',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthCare()
    {
        return $this->belongsTo(HealthCare::class);
    }
}
