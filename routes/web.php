<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/send', function () {
    $response = Http::post('https://api.semaphore.co/api/v4/messages', [
        'apikey' => '4781633c9d75ba093f3d224266f00ada',
        'number' => '09108818725', // ✅ recipient number
        'message' => 'Hello, John',
        // 'sendername' => 'SEMAPHORE', // ✅ optional, must be approved in your Semaphore account
    ]);

    return $response->json();
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
