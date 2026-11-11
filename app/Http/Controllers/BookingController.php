<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentStatusLog;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $services = Service::where('is_active', true)->get();
         $selectedServiceId = $request->query('service');

        return view('booking.create', [
            'services' => $services,
            'selectedServiceId' => $selectedServiceId,
        ]);
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'service_id' => 'nullable|exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'custom_request_note' => 'nullable|string',
            'custom_request_image' => 'nullable|image|max:2048',
        ]);
        $validated['phone'] = preg_replace('/[^\d+]/', '', $validated['phone']);

        if ($request->hasFile('custom_request_image')) {
        $validated['custom_request_image'] = $request->file('custom_request_image')->store('custom-requests', 'public');
        }

        $client = Client::firstOrCreate(
            ['phone' => $validated['phone']],
            ['name' => $validated['name'], 'email' => $validated['email'] ?? null]
        );

       $appointment = Appointment::create([
            'client_id' => $client->id,
            'service_id' => $validated['service_id'],
            'scheduled_at' => $validated['scheduled_at'],
            'status' => 'requested',
            'custom_request_note' => $validated['custom_request_note'] ?? null,
            'custom_request_image' => $validated['custom_request_image'] ?? null,
        ]);

        AppointmentStatusLog::create([
            'appointment_id' => $appointment->id,
            'status' => 'requested',
        ]);

        return redirect()
            ->route('booking.confirmation', $appointment->id)
            ->with('success', 'Your appointment has been requested!');
    }
    public function confirmation(Appointment $appointment){
         $appointment->load('service');

         return view('booking.confirmation', ['appointment' => $appointment]);
    }
}