<?php

use App\Http\Controllers\Household\HouseholdMemberController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->controller(HouseholdMemberController::class)->prefix('household')->group(function () {
    Route::get('/{household}', 'index')->name('household.index');
    Route::post('/', 'store')->name('household.store');
    Route::delete('/{id}', 'destroy')->name('household.destroy');
    Route::put('/{id}', 'update')->name('household.update');
});