<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    use Filterable;

    protected $guard = ['id'];

    protected $hidden = [
        'scheduleable_id', 
        'scheduleable_type',
    ];

    public function scheduleable()
    {
        return $this->morphTo();
    }
}
