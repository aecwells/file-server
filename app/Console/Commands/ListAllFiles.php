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
            $this->table(['ID', 'Name', 'Size', 'MIME Type', 'Uploaded'], [$file->toArray()]);
            $this->info("Collections:");
            $this->table(['ID', 'Name'], $file->collections->toArray());
        }
    }
}
