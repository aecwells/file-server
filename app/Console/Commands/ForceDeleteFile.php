<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class ForceDeleteFile extends Command
{
    protected $signature = 'app:force-delete-file {file_id}';
    protected $description = 'Force delete a file from the server';

    public function handle()
    {
        $media = Media::findOrFail($this->argument('file_id'));

        // Detach the media from all collections
        $media->collections()->detach();

        // Delete the file from storage
        Storage::disk('public')->delete($media->path);

        // Delete the record
        $media->delete();

        $this->info('File force deleted successfully.');
    }
}
