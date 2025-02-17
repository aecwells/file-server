<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/upload', [MediaController::class, 'index'])->name('upload.index');
    Route::get('/files', [MediaController::class, 'listAllFiles'])->name('upload.allFiles');
    Route::delete('/files/{id}', [MediaController::class, 'delete'])->name('upload.delete');
    Route::delete('/files/force/{id}', [MediaController::class, 'forceDelete'])->name('upload.forceDelete');
    Route::delete('/files/{mediaId}/collection/{collectionId}', [MediaController::class, 'removeAssociation'])->name('upload.removeAssociation');
    Route::get('/dashboard', [MediaController::class, 'listGroupedFiles'])->name('dashboard');
    Route::get('/download/{collection}/{filename}', [MediaController::class, 'download'])->name('download.file');
});

require __DIR__.'/auth.php';
