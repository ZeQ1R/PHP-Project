<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Show doctor dashboard
     */
    public function dashboard()
    {
        $doctor = Auth::user()->doctor;
        $pendingAppointments = $doctor->pendingAppointments()->with(['patient.user'])->get();
        $upcomingAppointments = $doctor->confirmedAppointments()
            ->with(['patient.user'])
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        $stats = [
            'total_today' => $doctor->appointments()
                ->where('appointment_date', now()->toDateString())
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'pending' => $doctor->pendingAppointments()->count(),
            'confirmed' => $doctor->confirmedAppointments()->count(),
            'completed_this_month' => $doctor->appointments()
                ->where('status', 'completed')
                ->whereMonth('appointment_date', now()->month)
                ->whereYear('appointment_date', now()->year)
                ->count(),
        ];

        return view('doctor.dashboard', compact('pendingAppointments', 'upcomingAppointments', 'stats'));
    }

    /**
     * Show all appointments
     */
    public function appointments(Request $request)
    {
        $doctor = Auth::user()->doctor;
        $query = $doctor->appointments()->with(['patient.user']);

        // Filter by status if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(20);

        return view('doctor.appointments', compact('appointments'));
    }

    /**
     * Show appointment details
     */
    public function showAppointment($id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::with(['patient.user'])
            ->where('doctor_id', $doctor->id)
            ->findOrFail($id);

        return view('doctor.appointment-details', compact('appointment'));
    }

    /**
     * Accept appointment
     */
    public function acceptAppointment($id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'pending')
            ->findOrFail($id);

        $appointment->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Appointment confirmed successfully!');
    }

    /**
     * Reject appointment
     */
    public function rejectAppointment(Request $request, $id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'pending')
            ->findOrFail($id);

        $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        $appointment->update([
            'status' => 'rejected',
            'cancellation_reason' => $request->cancellation_reason,
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Appointment rejected.');
    }

    /**
     * Complete appointment
     */
    public function completeAppointment(Request $request, $id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'confirmed')
            ->findOrFail($id);

        $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment->update([
            'status' => 'completed',
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Appointment completed successfully!');
    }

    /**
     * Show availability schedule
     */
    public function availability()
    {
        $doctor = Auth::user()->doctor;
        $availabilities = $doctor->availability()->get()->groupBy('day_of_week');

        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('doctor.availability', compact('availabilities', 'weekDays'));
    }

    /**
     * Store new availability
     */
    public function storeAvailability(Request $request)
    {
        $doctor = Auth::user()->doctor;

        $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:15|max:120',
        ]);

        DoctorAvailability::create([
            'doctor_id' => $doctor->id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'slot_duration' => $request->slot_duration,
            'is_available' => true,
        ]);

        return back()->with('success', 'Availability added successfully!');
    }

    /**
     * Delete availability
     */
    public function deleteAvailability($id)
    {
        $doctor = Auth::user()->doctor;
        $availability = DoctorAvailability::where('doctor_id', $doctor->id)->findOrFail($id);
        $availability->delete();

        return back()->with('success', 'Availability removed successfully!');
    }

    /**
     * Show doctor profile
     */
    public function profile()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        return view('doctor.profile', compact('user', 'doctor'));
    }

    /**
     * Update doctor profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'specialization' => 'required|string',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'years_of_experience' => 'required|integer|min:0',
            'qualifications' => 'nullable|string',
            'bio' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        $doctor->update([
            'specialization' => $request->specialization,
            'license_number' => $request->license_number,
            'years_of_experience' => $request->years_of_experience,
            'qualifications' => $request->qualifications,
            'bio' => $request->bio,
            'consultation_fee' => $request->consultation_fee,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
