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
        'pivot',
        'created_at',
        'updated_at',
        'file_id',
        'user_id'
    ];

    public function img()
    {
        return $this->morphOne(File::class, 'imgable');
    }
    
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    protected static function booted()
    {
        static::deleted(function ($entity) {
            foreach($entity->files() as $file) {
                $file->delete();
            };
            $entity->img->delete();
        });
    }
}
