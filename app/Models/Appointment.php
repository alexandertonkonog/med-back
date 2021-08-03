<?php

namespace App\Models;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Specialization;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    use Filterable;

    protected $guard = ['id'];

    protected $hidden = [
        'external_id',
        'pivot',
        'created_at',
        'updated_at',
        'clinic_id',
        'user_id',
        'service_id',
        'specialization_id',
        'doctor_id',
    ];

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function specialization() {
        return $this->belongsTo(Specialization::class);
    }

    public function client() {
        return $this->belongsTo(User::class);
    }

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }
}
