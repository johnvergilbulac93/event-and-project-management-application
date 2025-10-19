<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/users.php';
require __DIR__ . '/barangay_record.php';
require __DIR__ . '/event.php';
require __DIR__ . '/attendance.php';
require __DIR__ . '/project.php';
require __DIR__ . '/feedback.php';
require __DIR__ . '/report.php';
require __DIR__ . '/household.php';
require __DIR__ . '/dashboard.php';
require __DIR__ . '/home.php';
