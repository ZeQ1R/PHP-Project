<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'duration',
        'status',
        'symptoms',
        'notes',
        'diagnosis',
        'prescription',
        'cancellation_reason',
        'confirmed_at',
        'cancelled_at',
        'completed_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the patient for this appointment
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor for this appointment
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Scope for pending appointments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for confirmed appointments
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for completed appointments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for cancelled appointments
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope for upcoming appointments
     */
    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_date', '>=', now()->toDateString());
    }

    /**
     * Scope for past appointments
     */
    public function scopePast($query)
    {
        return $query->whereIn('status', ['completed', 'cancelled']);
    }

    /**
     * Check if appointment is editable
     */
    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) && 
               $this->appointment_date >= now()->toDateString();
    }

    /**
     * Check if appointment is cancellable
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) && 
               $this->appointment_date >= now()->toDateString();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            'rejected' => 'gray',
            default => 'gray',
        };
    }
}
