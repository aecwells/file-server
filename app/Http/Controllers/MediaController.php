<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        return view('upload');
    }
    
    public function listGroupedFiles()
    {
        $collections = Collection::with('media')->get();
        return view('files.index', compact('collections'));
    }

    public function upload(Request $request)
    {
        // Handle GET request for checking chunk existence
        if ($request->isMethod('get')) {
            return $this->checkChunkExists($request);
        }

        if (!$request->hasFile('file')) {
            return response()->json(['message' => 'No file uploaded', 'debug' => $request->all()], 400);
        }

        // Validate request
        $request->validate([
            'file' => 'required|file|max:15360', // 15GB max
            'collection' => 'nullable|string',
            'resumableChunkNumber' => 'nullable|integer',
            'resumableTotalChunks' => 'nullable|integer',
            'resumableIdentifier' => 'nullable|string',
            'resumableFilename' => 'nullable|string',
        ]);

        // Extract Resumable.js parameters
        $file = $request->file('file');
        $fileName = $request->input('resumableFilename') ?? $file->getClientOriginalName();
        $fileIdentifier = $request->input('resumableIdentifier') ?? Str::random(40);
        $chunkNumber = $request->input('resumableChunkNumber', 1);
        $totalChunks = $request->input('resumableTotalChunks', 1);
        $collection = $request->input('collection', 'uncategorized');

        // Temporary directory for chunks
        $tempDir = storage_path("app/temp_uploads/{$fileIdentifier}");
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Save the chunk
        $chunkPath = "{$tempDir}/{$chunkNumber}";
        file_put_contents($chunkPath, file_get_contents($file->getPathname()));

        // Check if all chunks have been uploaded
        if ($this->allChunksUploaded($tempDir, $totalChunks)) {
            \Log::info('upload allChunksUploaded', [
                'tempDir' => $tempDir,
                'totalChunks' => $totalChunks,
                'collection' => $collection,
                'fileName' => $fileName,
                'fileIdentifier' => $fileIdentifier,
            ]);
            return $this->assembleFile($tempDir, $fileName, $collection, $fileIdentifier);
        }

        return response()->json(['message' => 'Chunk uploaded'], 200);
    }

    // Handle chunk existence check (GET request)
    private function checkChunkExists(Request $request)
    {
        $fileIdentifier = $request->input('resumableIdentifier');
        $chunkNumber = $request->input('resumableChunkNumber');

        if (!$fileIdentifier || !$chunkNumber) {
            return response()->json(['message' => 'Missing identifier or chunk number'], 400);
        }

        // Check if the chunk already exists on the server
        $chunkPath = storage_path("app/temp_uploads/{$fileIdentifier}/{$chunkNumber}");
        if (file_exists($chunkPath)) {
            return response()->json(['message' => 'Chunk already uploaded'], 200);
        }

        return response()->json(['message' => 'Chunk not uploaded'], 404);
    }

    // Check if all chunks have been uploaded
    private function allChunksUploaded($tempDir, $totalChunks)
    {
        for ($i = 1; $i <= $totalChunks; $i++) {
            if (!file_exists("{$tempDir}/{$i}")) {
                return false;
            }
        }
        \Log::info('allChunksUploaded', [
            'tempDir' => $tempDir,
            'totalChunks' => $totalChunks,
        ]);
        return true;
    }

    private function assembleFile($tempDir, $fileName, $collectionNames, $fileIdentifier)
    {
        // Default to 'uncategorized' if no collections are provided
        $collectionNamesArray = $collectionNames ? explode(',', $collectionNames) : ['uncategorized'];

        // Single directory for all uploads
        $basePath = 'uploads/';

        // Generate a unique file name based on its hash for storage
        $fileHash = hash('sha256', $fileIdentifier);
        $finalName = $fileHash . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

        // Storage path where all files will be stored
        $finalPath = "{$basePath}{$finalName}";

        // Ensure the directory exists
        $storagePath = storage_path("app/public/{$basePath}");
        Storage::disk('public')->makeDirectory($storagePath);

        // Open the final file for writing
        $outputFile = "{$storagePath}{$finalName}";
        $output = fopen($outputFile, 'ab');
        if (!$output) {
            return response()->json(['message' => 'Failed to create output file'], 500);
        }

        \Log::info('assembleFile merge file', [
            'tempDir' => $tempDir,
            'fileName' => $fileName,
            'collection' => $collectionNames,
            'fileIdentifier' => $fileIdentifier,
        ]);

        // Merge file chunks
        for ($i = 1; $i <= count(scandir($tempDir)) - 2; $i++) {
            fwrite($output, file_get_contents("{$tempDir}/{$i}"));
            unlink("{$tempDir}/{$i}");
        }

        fclose($output);
        $this->deleteDirectory($tempDir);

        // Compute file metadata (size, MIME type)
        $fileSize = filesize($outputFile);
        $mimeType = mime_content_type($outputFile);

        \Log::info('assembleFile after merge file', [
            'fileHash' => $fileHash,
            'fileSize' => $fileSize,
            'mimeType' => $mimeType,
        ]);

        // Check if the file already exists based on its hash
        $media = Media::where('file_hash', $fileHash)->first();
        if (!$media) {
            // Store the file metadata in the database
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

        \Log::info('file uploaded', [
            'outputFile' => $outputFile,
            'media' => $media
        ]);

        // Ensure collection_id is set when creating a new collection
        foreach ($collectionNamesArray as $collectionName) {
            $collection = Collection::firstOrCreate([
                'name' => trim($collectionName),
            ]);
            // Attach media to collection via pivot table
            $collection->media()->syncWithoutDetaching($media->id);
        }

        return response()->json([
            'message' => 'File uploaded successfully',
            'media' => $media,
            'collections' => $collectionNamesArray,
        ], 200);
    }

    public function listFiles()
    {
        return response()->json(Media::all());
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = "{$dir}/{$file}";
            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath); // Recursively delete subdirectories
            } else {
                unlink($filePath);
            }
        }

        rmdir($dir);
    }

    public function delete($id)
    {
        $media = Media::findOrFail($id);

        // Detach the media from all collections
        $media->collections()->detach();

        // Check if the media is associated with any other collections
        if ($media->collections()->count() === 0) {
            // Delete the file from storage
            Storage::disk('public')->delete($media->path);

            // Delete the record
            $media->delete();
        }

        return redirect()->back()->with('success', 'File deleted successfully.');
    }

    public function forceDelete($id)
    {
        $media = Media::findOrFail($id);

        // Detach the media from all collections
        $media->collections()->detach();

        // Delete the file from storage
        Storage::disk('public')->delete($media->path);

        // Delete the record
        $media->delete();

        return redirect()->back()->with('success', 'File force deleted successfully.');
    }

    public function listAllFiles()
    {
        $files = Media::with('collections')->get();
        return view('files.list', compact('files'));
    }

    public function removeAssociation($mediaId, $collectionId)
    {
        $media = Media::findOrFail($mediaId);
        $collection = Collection::findOrFail($collectionId);

        // Detach the media from the specific collection
        $media->collections()->detach($collectionId);

        // Check if the media is associated with any other collections
        if ($media->collections()->count() === 0) {
            // Delete the file from storage
            Storage::disk('public')->delete($media->path);

            // Delete the record
            $media->delete();
        }

        return redirect()->back()->with('success', 'Association removed successfully.');
    }
}