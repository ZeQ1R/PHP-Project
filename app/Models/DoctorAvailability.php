<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    use HasFactory;

    protected $table = 'doctor_availability';

    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * Get the doctor that owns this availability
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get available time slots for this availability
     */
    public function getTimeSlots(): array
    {
        $slots = [];
        $start = strtotime($this->start_time);
        $end = strtotime($this->end_time);
        $duration = $this->slot_duration * 60; // Convert to seconds

        while ($start < $end) {
            $slots[] = date('H:i:s', $start);
            $start += $duration;
        }

        return $slots;
    }
}
