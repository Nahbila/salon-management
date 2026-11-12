<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatusLog;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['client', 'service', 'employee', 'payment'])
            ->latest('scheduled_at')
            ->get();

        $employees = User::where('role', 'employee')->orWhere('role', 'admin')->get();

        return view('admin.appointments.index', [
            'appointments' => $appointments,
            'employees' => $employees,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:requested,confirmed,in_progress,completed,cancelled',
            'employee_id' => 'nullable|exists:users,id',
            'quoted_price' => 'nullable|numeric|min:0',
        ]);

        $appointment->update([
            'status' => $validated['status'],
            'employee_id' => $validated['employee_id'] ?? $appointment->employee_id,
            'quoted_price' => $validated['quoted_price'] ?? $appointment->quoted_price,
        ]);

        AppointmentStatusLog::create([
            'appointment_id' => $appointment->id,
            'status' => $validated['status'],
            'changed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Appointment updated.');
    }

    public function markPaid(Appointment $appointment)
    {
        $amount = $appointment->service ? $appointment->service->price : $appointment->quoted_price;

        if ($amount === null) {
            return back()->with('error', 'Set a quoted price before marking this custom request as paid.');
        }

        Payment::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'amount' => $amount,
                'status' => 'paid',
                'paid_at' => now(),
            ]
        );

        return back()->with('success', 'Payment recorded.');
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->payment && $appointment->payment->status === 'paid') {
            return back()->with('error', 'A paid appointment cannot be deleted. It is part of your income records.');
        }

        if ($appointment->status !== 'cancelled') {
            return back()->with('error', 'Cancel the appointment first, then delete it.');
        }

        if ($appointment->custom_request_image) {
            Storage::disk('public')->delete($appointment->custom_request_image);
        }

        $appointment->delete();

        return back()->with('success', 'Appointment deleted.');
    }
}