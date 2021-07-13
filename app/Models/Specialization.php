<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends Model
{
    use HasFactory;
    use Filterable;

    protected $hidden = [
        'external_id',
    ];

    protected $guarded = [];


    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
