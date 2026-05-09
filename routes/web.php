<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

const PROFILE_ROUTE = '/profile';

Route::middleware('auth')->group(function () {
    Route::get(PROFILE_ROUTE, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(PROFILE_ROUTE, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(PROFILE_ROUTE, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
