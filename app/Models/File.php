<?php

namespace App\Models;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'user_id',
        'doctor_id',
        'service_id',
        'clinic_id',
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function doctorOwner()
    {
        return $this->belongsTo(Doctor::class, 'file_id');
    }

    public function serviceOwner()
    {
        return $this->belongsTo(Service::class, 'file_id');
    }
    
    public function clinicOwner()
    {
        return $this->belongsTo(Clinic::class, 'file_id');
    }

    public function userOwner()
    {
        return $this->belongsTo(User::class, 'file_id');
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }
}
