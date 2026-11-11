<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['appointment_id', 'amount', 'status', 'paid_at'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
