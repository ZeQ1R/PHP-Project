<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@dental.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'is_active' => true,
        ]);

        // Create Doctors
        $doctor1 = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor@dental.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'phone' => '+1234567891',
            'address' => '123 Medical Plaza, Healthcare City',
            'date_of_birth' => '1980-05-15',
            'gender' => 'male',
            'is_active' => true,
        ]);

        Doctor::create([
            'user_id' => $doctor1->id,
            'specialization' => 'General Dentistry',
            'license_number' => 'DEN001',
            'years_of_experience' => 15,
            'qualifications' => 'DDS - Harvard University, Certificate in Advanced Dentistry',
            'bio' => 'Experienced general dentist with focus on preventive care and cosmetic dentistry.',
            'consultation_fee' => 100.00,
            'is_available' => true,
        ]);

        $doctor2 = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@dental.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'phone' => '+1234567892',
            'address' => '456 Dental Avenue, Healthcare City',
            'date_of_birth' => '1985-08-22',
            'gender' => 'female',
            'is_active' => true,
        ]);

        Doctor::create([
            'user_id' => $doctor2->id,
            'specialization' => 'Orthodontics',
            'license_number' => 'DEN002',
            'years_of_experience' => 10,
            'qualifications' => 'DDS, MS Orthodontics - UCLA',
            'bio' => 'Specializing in braces and teeth alignment with modern techniques.',
            'consultation_fee' => 150.00,
            'is_available' => true,
        ]);

        $doctor3 = User::create([
            'name' => 'Dr. Michael Chen',
            'email' => 'michael.chen@dental.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'phone' => '+1234567893',
            'address' => '789 Smile Street, Healthcare City',
            'date_of_birth' => '1978-11-30',
            'gender' => 'male',
            'is_active' => true,
        ]);

        Doctor::create([
            'user_id' => $doctor3->id,
            'specialization' => 'Oral Surgery',
            'license_number' => 'DEN003',
            'years_of_experience' => 18,
            'qualifications' => 'DDS, Certificate in Oral & Maxillofacial Surgery',
            'bio' => 'Expert in surgical procedures including wisdom teeth extraction and dental implants.',
            'consultation_fee' => 200.00,
            'is_available' => true,
        ]);

        // Create Patients
        $patient1 = User::create([
            'name' => 'Alice Williams',
            'email' => 'patient@dental.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '+1234567894',
            'address' => '321 Patient Road, City',
            'date_of_birth' => '1990-03-10',
            'gender' => 'female',
            'is_active' => true,
        ]);

        Patient::create([
            'user_id' => $patient1->id,
            'blood_group' => 'A+',
            'medical_history' => 'No major medical conditions',
            'allergies' => 'Penicillin',
            'emergency_contact_name' => 'Bob Williams',
            'emergency_contact_phone' => '+1234567895',
        ]);

        $patient2 = User::create([
            'name' => 'Robert Brown',
            'email' => 'robert.brown@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '+1234567896',
            'address' => '654 Health Lane, City',
            'date_of_birth' => '1985-07-25',
            'gender' => 'male',
            'is_active' => true,
        ]);

        Patient::create([
            'user_id' => $patient2->id,
            'blood_group' => 'B+',
            'medical_history' => 'Diabetes Type 2',
            'allergies' => 'None',
            'emergency_contact_name' => 'Mary Brown',
            'emergency_contact_phone' => '+1234567897',
        ]);

        $patient3 = User::create([
            'name' => 'Emma Davis',
            'email' => 'emma.davis@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '+1234567898',
            'address' => '987 Wellness Court, City',
            'date_of_birth' => '1995-12-05',
            'gender' => 'female',
            'is_active' => true,
        ]);

        Patient::create([
            'user_id' => $patient3->id,
            'blood_group' => 'O+',
            'medical_history' => 'Asthma',
            'allergies' => 'Latex',
            'emergency_contact_name' => 'David Davis',
            'emergency_contact_phone' => '+1234567899',
        ]);
    }
}
