<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineAppointmentCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'vaccine_center_id',
        'appointments_count',
    ];

    /**
     * Increment appointments_count by 1 if it's below the threshold.
     *
     * @param int $threshold
     * @return bool
     */
    public function incrementAppointmentCount(int $threshold): bool
    {
        if ($this->appointments_count < $threshold) {
            $this->increment('appointments_count');
            return true;
        }
        return false;
    }
}
