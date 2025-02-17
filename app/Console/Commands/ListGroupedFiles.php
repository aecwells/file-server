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
            $this->table(['ID', 'Name', 'Size', 'MIME Type', 'Uploaded'], $collection->media->toArray());
        }
    }
}
