<?php

namespace App\Models;

use App\Models\File;
use App\Models\Group;
use App\Models\Right;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Schedule;
use App\Models\Connection;
use App\Models\Appointment;
use App\Models\Specialization;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'pivot',
        'created_at',
        'updated_at',
        'file_id',
        'parent_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function img()
    {
        return $this->morphOne(File::class, 'imgable');
    }

    public function schedule()
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }

    public function group() {
        return $this->belongsTo(Group::class, 'type');
    }

    public function rights() {
        return $this->morphOne(Right::class, 'rightable');
    }

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
