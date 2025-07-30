<?php

use App\Http\Controllers\Attendance\AttendanceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->controller(AttendanceController::class)->prefix('attendance')->group(function () {
    Route::redirect('/', 'attendance/list');
    Route::get('/list', 'index')->name('attendance.index');
    Route::get('/{event_id}', 'create')->name('attendance.scanner.index');
    Route::post('/', 'store')->name('attendance.store');
    Route::delete('/{event_id}', 'destroy')->name('attendance.destroy');
});
