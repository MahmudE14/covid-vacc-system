<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'daily_capacity',
    ];

    public function appointments()
    {
        return $this->hasMany(VaccineAppointment::class);
    }

}
