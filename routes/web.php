<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Redirect /dashboard to /admin
Route::get('/dashboard', function () {
    return redirect('/admin');
})->name('dashboard');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // About Management
    Route::get('/about', [App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/about', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');
    Route::delete('/about/resume', [App\Http\Controllers\Admin\AboutController::class, 'deleteResume'])->name('admin.about.delete-resume');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
