<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Collection;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Display the upload page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('files.upload');
    }
    
    /**
     * Display files grouped by collections.
     *
     * @return \Illuminate\View\View
     */
    public function listGroupedFiles()
    {
        $collections = Collection::has('media')->with('media')->get(); // Only include collections with media
        return view('files.index', compact('collections'));
    }

    /**
     * Handle file upload.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $media = $this->uploadService->handleUpload($request);

        return response()->json(['message' => 'File uploaded successfully', 'media' => $media]);
    }

    /**
     * List all files.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listFiles()
    {
        return response()->json(Media::all());
    }

    /**
     * Delete a directory and its contents.
     *
     * @param string $dir
     * @return void
     */
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

    /**
     * Delete a file.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Force delete a file.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * List all files with their collections.
     *
     * @return \Illuminate\View\View
     */
    public function listAllFiles()
    {
        $files = Media::with('collections')->get();
        return view('files.list', compact('files'));
    }

    /**
     * Remove a file association from a specific collection.
     *
     * @param int $mediaId
     * @param int $collectionId
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Download a file by collection and filename.
     *
     * @param string $collectionName
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($collectionName, $filename)
    {
        $collection = Collection::where('name', $collectionName)->firstOrFail();
        $media = $collection->media()->where('name', pathinfo($filename, PATHINFO_FILENAME))->firstOrFail();

        $filePath = storage_path("app/public/{$media->path}");

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $media->name . '.' . pathinfo($media->file_name, PATHINFO_EXTENSION));
    }
}