<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class UploadService
{
    public function handleUpload($request)
    {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            return $this->saveFile($save->getFile(), $request->input('collection', 'uncategorized'));
        }

        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone(),
            "status" => true
        ]);
    }

    private function saveFile($file, $collectionNames)
    {
        $fileName = $file->getClientOriginalName();
        $fileIdentifier = Str::random(40);
        $collectionNamesArray = $collectionNames ? explode(',', $collectionNames) : ['uncategorized'];
        $basePath = 'uploads/';
        $fileHash = hash_file('sha256', $file->getPathname()); // Use hash_file to ensure consistency
        $finalName = $fileHash . '.' . $file->getClientOriginalExtension();
        $storagePath = storage_path("app/public/{$basePath}");
        Storage::disk('public')->makeDirectory($storagePath);
        $file->move($storagePath, $finalName);

        $fileSize = filesize("{$storagePath}{$finalName}");
        $mimeType = mime_content_type("{$storagePath}{$finalName}");

        $media = Media::where('file_hash', $fileHash)->first();
        if (!$media) {
            $media = Media::create([
                'name' => pathinfo($fileName, PATHINFO_FILENAME),
                'file_name' => $finalName,
                'mime_type' => $mimeType,
                'path' => "{$basePath}{$finalName}",
                'disk' => 'public',
                'file_hash' => $fileHash,
                'size' => $fileSize,
            ]);
        }

        foreach ($collectionNamesArray as $collectionName) {
            $collection = Collection::firstOrCreate(['name' => trim($collectionName)]);
            $collection->media()->syncWithoutDetaching($media->id);
        }

        // Detach from 'uncategorized' collection if other collections are provided
        if (!in_array('uncategorized', $collectionNamesArray)) {
            $uncategorizedCollection = Collection::where('name', 'uncategorized')->first();
            if ($uncategorizedCollection) {
                $media->collections()->detach($uncategorizedCollection->id);
            }
        }

        return response()->json([
            'message' => 'File uploaded successfully',
            'media' => $media,
            'collections' => $collectionNamesArray,
        ], 200);
    }
}
