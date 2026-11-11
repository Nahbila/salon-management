<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'description', 'image', 'price', 'duration_minutes', 'target_gender', 'is_active'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function getDurationLabelAttribute(): string
{
    $hours = intdiv($this->duration_minutes, 60);
    $minutes = $this->duration_minutes % 60;

    return trim(($hours ? $hours . 'h ' : '') . ($minutes ? $minutes . 'm' : ''));
}
}
