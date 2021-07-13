<?php

namespace App\Models;

use App\Models\File;
use App\Models\Service;
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
        'user_id'
    ];

    protected $guarded = [];

    public function img()
    {
        return $this->hasOne(File::class, 'doctor_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class);
    }
}
