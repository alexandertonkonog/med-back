<?php

namespace App\Models;

use App\Models\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConnectionRef extends Model
{
    use HasFactory;

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    public function connections() {
        return $this->hasMany(Connection::class, 'type_id', 'id');
    }
}
