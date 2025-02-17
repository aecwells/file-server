<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;

class ListFiles extends Command
{
    protected $signature = 'app:list-files';
    protected $description = 'List all uploaded files';

    public function handle()
    {
        $files = Media::all();
        $this->table(['ID', 'Name', 'Size', 'MIME Type', 'Uploaded'], $files->toArray());
    }
}
