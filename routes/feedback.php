<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('feedback', '/feedback/list');

    Route::get('feedback/list', function () {
        return Inertia::render('feedback/Feedback');
    })->name('feedback.list');
});
