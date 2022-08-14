<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
