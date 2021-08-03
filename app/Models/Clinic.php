<?php

namespace App\Models;

use App\Models\File;
use App\Models\Appointment;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clinic extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = [];

    protected $hidden = [
        'external_id',
        'pivot',
        'created_at',
        'updated_at',
        'file_id',
        'user_id'
    ];

    public function img()
    {
        return $this->morphOne(File::class, 'imgable');
    }
    
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    protected static function booted()
    {
        static::deleted(function ($entity) {
            foreach($entity->files() as $file) {
                $file->delete();
            };
            $entity->img->delete();
        });
    }
}
