<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload');
    }
    
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:15360', // 15GB max file size
            'client_id' => 'required|string',
        ]);

        $file = $request->file('file');
        $client_id = $request->client_id;
        $filePath = "uploads/{$client_id}/" . $file->getClientOriginalName();

        $path = Storage::disk('local')->put($filePath, file_get_contents($file));

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['file' => $filePath])
            ->log('File uploaded');

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $filePath,
        ]);
    }
}
