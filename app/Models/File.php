<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'imgable_id',
        'fileable_id',
        'fileable_type',
        'imgable_type',
        'path',
        'disk'
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return asset(Storage::url($this->path));
    }

    public function imgable()
    {
        return $this->morphTo();
    }

    public function fileable()
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::deleted(function ($file) {
            $disk = $file->disk ?: 'public';
            Storage::disk($disk)->delete($file->path);
        });
    }
}
