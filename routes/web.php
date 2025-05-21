<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');


Route::group(['prefix' => 'transfers', 'middleware' => ['auth']], function () {
    Route::get('create', [TransferController::class, 'create'])->name('transfer.create');
    Route::post('store', [TransferController::class, 'store'])->name('transfer.store');
    Route::get('{transaction}/undo', [TransferController::class, 'undo'])->name('transfer.undo');
    Route::post('{transaction}/undo', [TransferController::class, 'undoStore'])->name('transfer.undoStore');
});

Route::group(['prefix' => 'deposits', 'middleware' => ['auth']], function () {
    Route::get('create', [DepositController::class, 'create'])->name('deposit.create');
    Route::get('{deposit}/undo', [DepositController::class, 'undo'])->name('deposit.undo');
});

require __DIR__ . '/auth.php';
