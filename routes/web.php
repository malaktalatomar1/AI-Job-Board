<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use Filament\Facades\Filament;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/jobs', [JobController::class, 'index'])
    ->name('jobs.index');

Route::get('/jobs/{id}', [JobController::class, 'show'])
    ->name('jobs.show');

Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])
    ->middleware('auth')
    ->name('jobs.apply');

Route::get('/MyApplications', [JobController::class, 'myApplications'])
    ->middleware('auth')
    ->name('applications.index');
Route::patch('/applications/{id}/cancel', [JobController::class, 'cancelApplication'])
    ->middleware('auth')
    ->name('applications.cancel');
require __DIR__.'/auth.php';
Route::post('/admin/custom-logout', function () {
    Filament::auth()->logout();

    session()->invalidate();
    session()->regenerateToken();

    return redirect('/');
})->name('admin.custom-logout');
