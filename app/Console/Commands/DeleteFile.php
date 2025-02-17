<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class DeleteFile extends Command
{
    protected $signature = 'app:delete-file {file_id}';
    protected $description = 'Delete a file';

    public function handle()
    {
        $media = Media::findOrFail($this->argument('file_id'));

        // Detach the media from all collections
        $media->collections()->detach();

        // Check if the media is associated with any other collections
        if ($media->collections()->count() === 0) {
            // Delete the file from storage
            Storage::disk('public')->delete($media->path);

            // Delete the record
            $media->delete();
        }

        $this->info('File deleted successfully.');
    }
}
