<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Remove 'media_id' and 'collection_id'

    public function media()
    {
        return $this->belongsToMany(Media::class, 'collection_media');
    }
}