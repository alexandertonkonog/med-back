<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\File;

class Clinic extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = [];

    protected $hidden = [
        'external_id',
    ];

    public function img()
    {
        return $this->hasOne(File::class, 'clinic_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class);
    }
}
