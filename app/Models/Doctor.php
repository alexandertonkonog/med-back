<?php

namespace App\Models;

use App\Models\File;
use App\Models\Service;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Specialization;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;
    use Filterable;

    protected $hidden = [
        'external_id',
        'user_id',
        'pivot',
        'created_at',
        'updated_at',
        'file_id'
    ];

    protected $guarded = [];

    public function img()
    {
        return $this->morphOne(File::class, 'imgable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function schedule()
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }    

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class);
    }

    protected static function booted()
    {
        static::deleted(function ($doctor) {
            foreach($doctor->files() as $file) {
                $file->delete();
            };
            $doctor->services()->detach();
            $doctor->specializations()->detach();
            $doctor->img->delete();
        });
    }
}
