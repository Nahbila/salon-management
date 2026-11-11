<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['client_id', 'employee_id', 'service_id', 'scheduled_at', 'status', 'notes', 'custom_request_note', 'custom_request_image', 'quoted_price'];
    protected $casts = [
    'scheduled_at' => 'datetime',
];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(AppointmentStatusLog::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
