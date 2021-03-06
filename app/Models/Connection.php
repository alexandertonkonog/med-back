<?php

namespace App\Models;

use App\Models\ConnectionRef;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Connection extends Model
{
    use HasFactory;
    use Filterable;

    protected $hidden = [
        'user_id',
        'pivot',
        'created_at',
        'updated_at',
        'type_id',
        'subtype_id'
    ];

    protected $guarded = [];

    public function type() {
        return $this->belongsTo(ConnectionRef::class, 'type_id', 'id');
    }
}
