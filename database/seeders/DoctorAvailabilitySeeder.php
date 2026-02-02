<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\DoctorAvailability;

class DoctorAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();
        
        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        foreach ($doctors as $doctor) {
            // Set availability for weekdays
            foreach ($weekdays as $day) {
                // Morning shift: 9:00 AM - 12:00 PM
                DoctorAvailability::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    'slot_duration' => 30,
                    'is_available' => true,
                ]);
                
                // Afternoon shift: 2:00 PM - 5:00 PM
                DoctorAvailability::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '14:00:00',
                    'end_time' => '17:00:00',
                    'slot_duration' => 30,
                    'is_available' => true,
                ]);
            }
            
            // Saturday morning only for some doctors
            if ($doctor->id % 2 == 1) {
                DoctorAvailability::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => 'Saturday',
                    'start_time' => '09:00:00',
                    'end_time' => '13:00:00',
                    'slot_duration' => 30,
                    'is_available' => true,
                ]);
            }
        }
    }
}
