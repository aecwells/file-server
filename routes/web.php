<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UploadController;
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
    //Route::post('/upload', [MediaController::class, 'upload'])->name('upload.store');
    Route::get('/files', [MediaController::class, 'listFiles'])->name('upload.list');
    Route::delete('/files/{id}', [MediaController::class, 'delete'])->name('upload.delete');
    Route::delete('/files/force/{id}', [MediaController::class, 'forceDelete'])->name('upload.forceDelete');
    Route::delete('/files/{mediaId}/collection/{collectionId}', [MediaController::class, 'removeAssociation'])->name('upload.removeAssociation');
    Route::get('/dashboard', [MediaController::class, 'listGroupedFiles'])->name('dashboard');
    Route::get('/all-files', [MediaController::class, 'listAllFiles'])->name('upload.allFiles');
});

#Route::get('/upload', [UploadController::class, 'index'])->name('upload.index');
#Route::post('/upload', [UploadController::class, 'upload'])->name('upload.store');

require __DIR__.'/auth.php';
