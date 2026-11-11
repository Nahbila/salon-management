<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentStatusLog;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientSpaceController extends Controller
{
    public function lookup()
    {
        return view('client.lookup');
    }

    public function find(Request $request)
    {
        $request->validate(['phone' => 'required|string|max:20']);

        $phone = preg_replace('/[^\d+]/', '', $request->phone);
        $client = Client::where('phone', $phone)->first();

        if (! $client) {
            return back()->withInput()->withErrors(['phone' => 'No appointments found for this number.']);
        }

        session(['client_space_id' => $client->id]);

        return redirect()->route('client.index');
    }

    public function index()
    {
        $client = $this->currentClient();

        if (! $client) {
            return redirect()->route('client.lookup');
        }

        $appointments = $client->appointments()
            ->with(['service', 'employee', 'statusLogs'])
            ->latest('scheduled_at')
            ->get();

        return view('client.index', [
            'client' => $client,
            'appointments' => $appointments,
        ]);
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorizeChange($appointment);

        $appointment->update(['status' => 'cancelled']);
        $this->logStatus($appointment, 'cancelled');

        return back()->with('success', 'Your appointment has been cancelled.');
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        $this->authorizeChange($appointment);

        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        $appointment->update([
            'scheduled_at' => $validated['scheduled_at'],
            'status' => 'requested',
        ]);
        $this->logStatus($appointment, 'requested');

        return back()->with('success', 'New date sent. It will be confirmed again shortly.');
    }

    public function exit()
    {
        session()->forget('client_space_id');

        return redirect()->route('catalog.index');
    }

    private function currentClient(): ?Client
    {
        $id = session('client_space_id');

        return $id ? Client::find($id) : null;
    }

    private function authorizeChange(Appointment $appointment): void
    {
        $client = $this->currentClient();

        abort_unless($client && $appointment->client_id === $client->id, 403);
        abort_unless(
            in_array($appointment->status, ['requested', 'confirmed']) && $appointment->scheduled_at->isFuture(),
            403
        );
    }

    private function logStatus(Appointment $appointment, string $status): void
    {
        AppointmentStatusLog::create([
            'appointment_id' => $appointment->id,
            'status' => $status,
            'changed_by' => null,
        ]);
    }
}