<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Post\PostController;
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function() {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('user')->group(function () {
        Route::resource('posts', PostController::class);
    });

    Route::middleware('admin')->group(function (){
        Route::resource('admin', AdminController::class);
        Route::get('admin/{id}/restore',[AdminController::class, 'restore'])->name('admin.restore');
        Route::get('admin/{id}/delete',[AdminController::class, 'permanentDelete'])->name('admin.delete');

    });
});







require __DIR__.'/auth.php';
