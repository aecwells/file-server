<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Collection;

class ListCollections extends Command
{
    protected $signature = 'app:list-collections';
    protected $description = 'Display all collections and their attached files';

    public function handle()
    {
        $collections = Collection::with('media')->get();
        foreach ($collections as $collection) {
            $this->info("Collection: {$collection->name}");
            $mediaData = $collection->media->map(function ($media) {
                return [
                    'ID' => $media->id,
                    'Name' => $media->name,
                    'Size' => $this->humanReadableSize($media->size),
                    'MIME Type' => $media->mime_type,
                    'Uploaded' => $media->created_at->diffForHumans()
                ];
            })->toArray();
            $this->table(['ID', 'Name', 'Size', 'MIME Type', 'Uploaded'], $mediaData);
        }
    }

    private function humanReadableSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
