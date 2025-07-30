<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('barangay-record', '/barangay-record/list');

    Route::get('barangay-record/list', function () {
        return Inertia::render('barangay-record/BarangayRecord');
    })->name('barangay-record.list');
});
