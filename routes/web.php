<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/tables');
    }
    return redirect('/login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/tables', [TableController::class, 'index'])->name('dashboard');
    Route::post('/tables', [TableController::class, 'create'])->name('create.table');
    Route::get('/tables/{id}', [TableController::class, 'show'])->name('table.show');
    Route::put('/tables/{id}', [TableController::class, 'update'])->name('update.table');
    Route::delete('/tables/{id}', [TableController::class, 'destroy'])->name('delete.table');

    // Table rows routes
    Route::post('/tables/{tableId}/rows', [TableController::class, 'storeRow'])->name('table.row.store');
    Route::put('/tables/{tableId}/rows/{rowId}', [TableController::class, 'updateRow'])->name('table.row.update');
    Route::delete('/tables/{tableId}/rows/{rowId}', [TableController::class, 'destroyRow'])->name('table.row.delete');
});



Route::post('/register-user', [RegisteredUserController::class, 'store'])
    ->middleware('auth')
    ->name('register-user');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user', [RegisteredUserController::class, 'create'])->name('user.create');
});

require __DIR__ . '/auth.php';
