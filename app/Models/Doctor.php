<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'license_number',
        'years_of_experience',
        'qualifications',
        'bio',
        'consultation_fee',
        'is_available',
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the user that owns the doctor profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all appointments for this doctor
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get availability schedules for this doctor
     */
    public function availability()
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    /**
     * Get pending appointments
     */
    public function pendingAppointments()
    {
        return $this->hasMany(Appointment::class)->where('status', 'pending');
    }

    /**
     * Get confirmed appointments
     */
    public function confirmedAppointments()
    {
        return $this->hasMany(Appointment::class)->where('status', 'confirmed');
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
}
