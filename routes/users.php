<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->controller(UserController::class)->prefix('user')->group(function () {
    Route::redirect('/', 'user/list');
    Route::get('/list', 'index')->name('user.index');
    Route::get('/', 'create')->name('user.create.index');
    Route::post('/', 'store')->name('user.store');
    Route::get('/{user}', 'updateIndex')->name('user.update.index');
    Route::put('/{user}', 'update')->name('user.update');
    Route::delete('/{user}', 'destroy')->name('user.destroy');
});
