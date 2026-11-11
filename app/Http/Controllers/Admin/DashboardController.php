<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $todayCount = Appointment::whereDate('scheduled_at', today())->count();
        $pendingCount = Appointment::where('status', 'requested')->count();
        $recentAppointments = Appointment::with(['client', 'service'])
            ->latest('scheduled_at')
            ->take(10)
            ->get();

        return view('admin.dashboard', [
            'todayCount' => $todayCount,
            'pendingCount' => $pendingCount,
            'recentAppointments' => $recentAppointments,
        ]);
    }
}