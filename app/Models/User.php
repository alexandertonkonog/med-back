<?php

namespace App\Models;

use App\Models\File;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Schedule;
use App\Models\Connection;
use App\Models\Appointment;
use App\Models\UserType;
use App\Models\Specialization;
use App\Constants\RightsHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authentificable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authentificable implements JWTSubject
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
    ];

    protected $appends = [
        'roles',
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
        'rights',
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getRolesAttribute()
    {
        return json_decode($this->rights);
    }

    public function getTypeAttribute()
    {
        $userTypes = $this->userTypes()->get()->toArray();
        return array_map(function($userType) {
            return $userType['id'];
        }, $userTypes);
    }

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

    public function userTypes() {
        return $this->belongsToMany(UserType::class);
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
