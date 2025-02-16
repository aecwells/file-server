<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'file_name', 'mime_type', 'path', 'disk', 'file_hash', 'size'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($media) {
            Storage::disk($media->disk)->delete($media->path);
        });
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_media');
    }
}
