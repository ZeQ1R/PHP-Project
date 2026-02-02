<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Show patient dashboard
     */
    public function dashboard()
    {
        $patient = Auth::user()->patient;
        $upcomingAppointments = $patient->upcomingAppointments()->with(['doctor.user'])->get();
        $recentAppointments = $patient->pastAppointments()->with(['doctor.user'])->take(5)->get();

        return view('patient.dashboard', compact('upcomingAppointments', 'recentAppointments'));
    }

    /**
     * Show doctors list
     */
    public function doctors()
    {
        $doctors = Doctor::with('user')->where('is_available', true)->get();
        return view('patient.doctors', compact('doctors'));
    }

    /**
     * Show booking form for a specific doctor
     */
    public function showBooking($doctorId)
    {
        $doctor = Doctor::with('user')->findOrFail($doctorId);
        return view('patient.book-appointment', compact('doctor'));
    }

    /**
     * Get available slots for a doctor on a specific date
     */
    public function getAvailableSlots(Request $request, $doctorId)
    {
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->format('l');

        $availabilities = DoctorAvailability::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->get();

        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->toArray();

        $availableSlots = [];
        foreach ($availabilities as $availability) {
            $slots = $availability->getTimeSlots();
            foreach ($slots as $slot) {
                if (!in_array($slot, $bookedSlots)) {
                    $availableSlots[] = [
                        'time' => $slot,
                        'formatted' => Carbon::parse($slot)->format('h:i A'),
                    ];
                }
            }
        }

        return response()->json($availableSlots);
    }

    /**
     * Store new appointment
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'symptoms' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $patient = Auth::user()->patient;

        // Check if slot is still available
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existingAppointment) {
            return back()->with('error', 'This time slot is no longer available. Please select another slot.');
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'duration' => 30,
            'status' => 'pending',
            'symptoms' => $request->symptoms,
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment booked successfully!');
    }

    /**
     * Show all appointments
     */
    public function appointments()
    {
        $patient = Auth::user()->patient;
        $appointments = $patient->appointments()
            ->with(['doctor.user'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('patient.appointments', compact('appointments'));
    }

    /**
     * Show appointment details
     */
    public function showAppointment($id)
    {
        $patient = Auth::user()->patient;
        $appointment = Appointment::with(['doctor.user'])
            ->where('patient_id', $patient->id)
            ->findOrFail($id);

        return view('patient.appointment-details', compact('appointment'));
    }

    /**
     * Show edit appointment form
     */
    public function editAppointment($id)
    {
        $patient = Auth::user()->patient;
        $appointment = Appointment::with(['doctor.user'])
            ->where('patient_id', $patient->id)
            ->findOrFail($id);

        if (!$appointment->isEditable()) {
            return back()->with('error', 'This appointment cannot be edited.');
        }

        return view('patient.edit-appointment', compact('appointment'));
    }

    /**
     * Update appointment
     */
    public function updateAppointment(Request $request, $id)
    {
        $patient = Auth::user()->patient;
        $appointment = Appointment::where('patient_id', $patient->id)->findOrFail($id);

        if (!$appointment->isEditable()) {
            return back()->with('error', 'This appointment cannot be edited.');
        }

        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'symptoms' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Check if new slot is available
        $existingAppointment = Appointment::where('doctor_id', $appointment->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('id', '!=', $id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existingAppointment) {
            return back()->with('error', 'This time slot is not available. Please select another slot.');
        }

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'symptoms' => $request->symptoms,
            'notes' => $request->notes,
            'status' => 'pending', // Reset to pending if rescheduled
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment updated successfully!');
    }

    /**
     * Cancel appointment
     */
    public function cancelAppointment(Request $request, $id)
    {
        $patient = Auth::user()->patient;
        $appointment = Appointment::where('patient_id', $patient->id)->findOrFail($id);

        if (!$appointment->isCancellable()) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
            'cancelled_at' => now(),
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment cancelled successfully.');
    }

    /**
     * Show patient profile
     */
    public function profile()
    {
        $user = Auth::user();
        $patient = $user->patient;

        return view('patient.profile', compact('user', 'patient'));
    }

    /**
     * Update patient profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $patient = $user->patient;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        $patient->update([
            'blood_group' => $request->blood_group,
            'medical_history' => $request->medical_history,
            'allergies' => $request->allergies,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
