<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_group',
        'medical_history',
        'allergies',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    /**
     * Get the user that owns the patient profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all appointments for this patient
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get upcoming appointments
     */
    public function upcomingAppointments()
    {
        return $this->hasMany(Appointment::class)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time');
    }

    /**
     * Get past appointments
     */
    public function pastAppointments()
    {
        return $this->hasMany(Appointment::class)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc');
    }

    /**
     * Get pending appointments
     */
    public function pendingAppointments()
    {
        return $this->hasMany(Appointment::class)->where('status', 'pending');
    }
}
