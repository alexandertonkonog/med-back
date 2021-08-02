<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Right;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rights() {
        return $this->morphOne(Right::class, 'rightable');
    }

    public function users() {
        return $this->hasMany(User::class, 'type');
    }

    public function img()
    {
        return $this->morphOne(File::class, 'imgable');
    }
}
