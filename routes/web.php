<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuditLogController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* ================= USER ROUTES ================= */
Route::middleware('auth')->group(function () {

    Route::get('/my-profile', [ProfileController::class, 'index'])
        ->name('profile.view');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tasks', TaskController::class);
});

/* ================= ADMIN ROUTES ================= */
Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    Route::get('/admin', function () {
        return 'ADMIN PAGE - ACCESS GRANTED';
    });

    Route::get('/admin/audit-logs', [AuditLogController::class, 'index'])
        ->name('admin.audit.logs');
});

require __DIR__.'/auth.php';

