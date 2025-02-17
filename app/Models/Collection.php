<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Collection
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The media that belong to the collection.
     */
    public function media()
    {
        return $this->belongsToMany(Media::class, 'collection_media');
    }
}