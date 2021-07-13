<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Doctor;
use App\Models\File;

class Service extends Model
{
    use HasFactory;
    use Filterable;

    protected $hidden = [
        'external_id',
    ];

    protected $guarded = [];

    public function img()
    {
        return $this->hasOne(File::class, 'service_id');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
