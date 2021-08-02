<?php

namespace App\Models;

use App\Models\File;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    use Filterable;

    protected $hidden = [
        'external_id',
        'pivot',
        'created_at',
        'updated_at',
        'file_id',
        'user_id'
    ];

    protected $guarded = [];

    public function img()
    {
        return $this->morphOne(File::class, 'imgable');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function specializations() {
        return $this->belongsToMany(Specialization::class);
    }

    protected static function booted()
    {
        static::deleted(function ($doctor) {
            $doctor->doctors()->detach();
            $doctor->specializations()->detach();
            $doctor->img->delete();
        });
    }
}
