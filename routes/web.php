<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

$profileRoute = '/profile';

Route::middleware('auth')->group(function () use ($profileRoute) {
    Route::get($profileRoute, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch($profileRoute, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete($profileRoute, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
