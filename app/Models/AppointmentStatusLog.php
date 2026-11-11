<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentStatusLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['appointment_id', 'status', 'changed_by', 'changed_at'];
    protected $casts = [
    'changed_at' => 'datetime',];
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
