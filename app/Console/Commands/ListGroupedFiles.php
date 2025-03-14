<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Collection;

class ListGroupedFiles extends Command
{
    protected $signature = 'app:list-grouped-files';
    protected $description = 'Display files grouped by collections';

    public function handle()
    {
        $collections = Collection::with('media')->get();
        foreach ($collections as $collection) {
            $this->info("Collection: {$collection->name}");
            $mediaData = $collection->media->map(function ($media) {
                return [
                    'ID' => $media->id,
                    'Name' => $media->name,
                    'Size' => $media->size,
                    'MIME Type' => $media->mime_type,
                    'Uploaded' => $media->created_at->diffForHumans()
                ];
            })->toArray();
            $this->table(['ID', 'Name', 'Size', 'MIME Type', 'Uploaded'], $mediaData);
        }
    }
}
