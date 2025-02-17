<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use App\Models\Collection;
use Illuminate\Support\Facades\Storage;

class RemoveFileAssociation extends Command
{
    protected $signature = 'app:remove-file-association {file_id} {collection_id}';
    protected $description = 'Remove a file association from a specific collection';

    public function handle()
    {
        $media = Media::findOrFail($this->argument('file_id'));
        $collection = Collection::findOrFail($this->argument('collection_id'));

        // Detach the media from the specific collection
        $media->collections()->detach($collection->id);

        // Check if the media is associated with any other collections
        if ($media->collections()->count() === 0) {
            // Delete the file from storage
            Storage::disk('public')->delete($media->path);

            // Delete the record
            $media->delete();
        }

        $this->info('Association removed successfully.');
    }
}
