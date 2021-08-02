<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends Model
{
    use HasFactory;
    use Filterable;

    protected $hidden = [
        'external_id',
        'pivot',
        'created_at',
        'updated_at',
        'user_id'
    ];

    protected $guarded = [];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    protected static function booted()
    {
        static::deleted(function ($entity) {
            $entity->doctors()->detach();
            $entity->services()->detach();
        });
    }
}
