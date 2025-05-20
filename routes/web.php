<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');


Route::group(['prefix' => 'transfers', 'middleware' => ['auth']], function () {
    Route::get('create', [TransferController::class, 'create'])->name('transfer.create');
    Route::get('{transfer}/undo', [TransferController::class, 'undo'])->name('transfer.undo');
});

Route::group(['prefix' => 'deposits', 'middleware' => ['auth']], function () {
    Route::get('create', [DepositController::class, 'create'])->name('deposit.create');
    Route::get('{deposit}/undo', [DepositController::class, 'undo'])->name('deposit.undo');
});

require __DIR__ . '/auth.php';
