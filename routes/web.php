<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FlexibleController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FlexibleController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('flexibles', FlexibleController::class)->except(['index', 'show'])->middleware('auth');
Route::get('flexibles', [FlexibleController::class, 'index'])->name('flexibles.index');
Route::get('flexibles/{flexible}', [FlexibleController::class, 'show'])->name('flexibles.show');
Route::delete('/photos/{photo}', [FlexibleController::class, 'deletePhoto'])->name('photos.delete');
Route::get('/export', [ExportController::class, 'export'])->name('export');


Route::post('/upload-image', function (Illuminate\Http\Request $request) {
    $request->validate(['image' => 'required|image']);
    $path = $request->file('image')->store('public/images');
    return back()->with('success', 'Image uploaded successfully');
})->name('image.upload');
Route::post('flexibles/{flexible}/updateFields', [FlexibleController::class, 'updateFields'])->name('flexibles.updateFields');
require __DIR__.'/auth.php';