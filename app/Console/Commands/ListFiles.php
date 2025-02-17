<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use Illuminate\Support\Str;

class ListFiles extends Command
{
    protected $signature = 'app:list-files';
    protected $description = 'List all uploaded files';

    public function handle()
    {
        $files = Media::all();
        $fileData = $files->map(function ($file) {
            return [
                'ID' => $file->id,
                'Name' => Str::limit($file->name, 50),
                'Size' => $this->humanReadableSize($file->size),
                'MIME Type' => $file->mime_type,
                'Uploaded' => $file->created_at->diffForHumans()
            ];
        })->toArray();
        $this->table(['ID', 'Name', 'Size', 'MIME Type', 'Uploaded'], $fileData);
    }

    private function humanReadableSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
