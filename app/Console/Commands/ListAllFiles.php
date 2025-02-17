<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;

class ListAllFiles extends Command
{
    protected $signature = 'app:list-all-files';
    protected $description = 'Display a list of all files with their details and actions';

    public function handle()
    {
        $files = Media::with('collections')->get();
        foreach ($files as $file) {
            $this->info("File: {$file->name}");
            $this->table(
                ['ID', 'Name', 'Size', 'MIME Type', 'Uploaded'],
                [[
                    'ID' => $file->id,
                    'Name' => $file->name,
                    'Size' => $this->humanReadableSize($file->size),
                    'MIME Type' => $file->mime_type,
                    'Uploaded' => $file->created_at->diffForHumans()
                ]]
            );
            $this->info("Collections:");
            $collections = $file->collections->map(function ($collection) {
                return [
                    'ID' => $collection->id,
                    'Name' => $collection->name
                ];
            })->toArray();
            $this->table(['ID', 'Name'], $collections);
        }
    }

    private function humanReadableSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
