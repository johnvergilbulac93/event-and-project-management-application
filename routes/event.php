<?php

use App\Http\Controllers\Event\EventController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->controller(EventController::class)->prefix('event')->group(function () {
    Route::redirect('/', 'event/list');
    Route::get('/list', 'index')->name('event.index');
    Route::get('/', 'create')->name('event.create.index');
    Route::post('/', 'store')->name('event.store');
    Route::get('/{event_id}', 'updateIndex')->name('event.update.index');
    Route::put('/{event_id}', 'update')->name('event.update');
    Route::delete('/{event_id}', 'destroy')->name('event.destroy');


});
