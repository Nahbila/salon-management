<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dashboard</h1>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-primary me-2">Manage Appointments</a>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-primary me-2">Manage Services</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Today's Appointments</h5>
                    <p class="display-6">{{ $todayCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Requests</h5>
                    <p class="display-6">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2>Recent Appointments</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Client</th>
                <th>Service</th>
                <th>Date & Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->client->name }}</td>
                    <td>{{ $appointment->service->name ?? 'Custom request' }}</td>
                    <td>{{ $appointment->scheduled_at->format('d M Y, h:i A') }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No appointments yet.</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
</body>
</html>