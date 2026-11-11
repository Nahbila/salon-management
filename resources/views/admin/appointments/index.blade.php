<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Appointments</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Client</th>
                <th>Phone</th>
                <th>Service</th>
                <th>Custom Request</th>
                <th>Date & Time</th>
                <th>Employee</th>
                <th>Status</th>
                <th>Payment</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->client->name }}</td>
                    <td>{{ $appointment->client->phone }}</td>
                    <td>{{ $appointment->service->name }} ({{ $appointment->service->price }} dt)</td>
                    <td>
                        @if ($appointment->custom_request_note || $appointment->custom_request_image)
                        @if ($appointment->custom_request_note)
                            <div class="small">{{ $appointment->custom_request_note }}</div>
                         @endif
                        @if ($appointment->custom_request_image)
                            <a href="{{ asset('storage/' . $appointment->custom_request_image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $appointment->custom_request_image) }}" style="height: 50px;" class="rounded">
                                </a>
                        @endif
                        @else
                             —
                        @endif
                    </td>
                    <td>{{ $appointment->scheduled_at->format('d M Y, h:i A') }}</td>
                    <td>{{ $appointment->employee->name ?? '—' }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                    <td>
                        @if ($appointment->payment && $appointment->payment->status === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-secondary">Unpaid</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" class="d-flex gap-2 mb-2">
                            @csrf
                            <select name="employee_id" class="form-select form-select-sm">
                                <option value="">-- Assign employee --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" @selected($appointment->employee_id === $employee->id)>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select form-select-sm">
                                @foreach (['requested', 'confirmed', 'in_progress', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($appointment->status === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @if (! $appointment->service)
                                <input type="number" step="0.01" name="quoted_price" class="form-control form-control-sm" placeholder="Quote price (dt)" value="{{ $appointment->quoted_price }}" style="max-width: 120px;">
                            @endif
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>

                        @if (! $appointment->payment || $appointment->payment->status !== 'paid')
                            <form method="POST" action="{{ route('admin.appointments.markPaid', $appointment->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Mark Paid</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">No appointments yet.</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
</body>
</html>