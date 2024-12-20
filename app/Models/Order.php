<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'clinic_id',
        'service',
        'price',
        'payment_url',
        'status',
        'duration',
        'schedule'
    ];
}
