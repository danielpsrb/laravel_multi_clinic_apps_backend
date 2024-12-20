<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    //
    protected $fillable =[
        'name',
        'address',
        'phone',
        'email',
        'open_time',
        'close_time',
        'website',
        'note',
        'image',
        'specialization',
        'clinic_latitude',
        'clinic_longitude',
        'operational_status',
        'contact_phone'
    ];
}
