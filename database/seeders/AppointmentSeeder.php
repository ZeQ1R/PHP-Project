<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        
        // Create some past appointments
        Appointment::create([
            'patient_id' => $patients[0]->id,
            'doctor_id' => $doctors[0]->id,
            'appointment_date' => Carbon::now()->subDays(7),
            'appointment_time' => '10:00:00',
            'duration' => 30,
            'status' => 'completed',
            'symptoms' => 'Regular checkup',
            'notes' => 'Patient reported no issues',
            'diagnosis' => 'Healthy teeth, no cavities',
            'completed_at' => Carbon::now()->subDays(7),
        ]);
        
        Appointment::create([
            'patient_id' => $patients[1]->id,
            'doctor_id' => $doctors[1]->id,
            'appointment_date' => Carbon::now()->subDays(14),
            'appointment_time' => '14:30:00',
            'duration' => 30,
            'status' => 'completed',
            'symptoms' => 'Teeth cleaning',
            'notes' => 'Regular cleaning appointment',
            'diagnosis' => 'Plaque removed, good oral hygiene',
            'completed_at' => Carbon::now()->subDays(14),
        ]);
        
        // Create pending appointments
        Appointment::create([
            'patient_id' => $patients[0]->id,
            'doctor_id' => $doctors[1]->id,
            'appointment_date' => Carbon::now()->addDays(2),
            'appointment_time' => '11:00:00',
            'duration' => 30,
            'status' => 'pending',
            'symptoms' => 'Toothache on lower right side',
            'notes' => 'Pain started 3 days ago',
        ]);
        
        Appointment::create([
            'patient_id' => $patients[2]->id,
            'doctor_id' => $doctors[0]->id,
            'appointment_date' => Carbon::now()->addDays(3),
            'appointment_time' => '15:00:00',
            'duration' => 30,
            'status' => 'pending',
            'symptoms' => 'Dental consultation for braces',
            'notes' => 'Interested in orthodontic treatment',
        ]);
        
        // Create confirmed appointments
        Appointment::create([
            'patient_id' => $patients[1]->id,
            'doctor_id' => $doctors[2]->id,
            'appointment_date' => Carbon::now()->addDays(5),
            'appointment_time' => '09:30:00',
            'duration' => 30,
            'status' => 'confirmed',
            'symptoms' => 'Wisdom tooth extraction consultation',
            'notes' => 'Referred by general dentist',
            'confirmed_at' => Carbon::now()->subHours(24),
        ]);
        
        // Create a cancelled appointment
        Appointment::create([
            'patient_id' => $patients[2]->id,
            'doctor_id' => $doctors[1]->id,
            'appointment_date' => Carbon::now()->addDays(1),
            'appointment_time' => '10:30:00',
            'duration' => 30,
            'status' => 'cancelled',
            'symptoms' => 'Follow-up appointment',
            'cancellation_reason' => 'Patient had to reschedule due to personal emergency',
            'cancelled_at' => Carbon::now()->subHours(12),
        ]);
    }
}
