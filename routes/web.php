<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Notes routes
    Route::resource('notes', NoteController::class);
    Route::patch('/notes/{note}/toggle-important', [NoteController::class, 'toggleImportant'])->name('notes.toggle-important');
    Route::patch('/notes/{note}/toggle-bookmarked', [NoteController::class, 'toggleBookmarked'])->name('notes.toggle-bookmarked');
    
    // Attachments routes
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
