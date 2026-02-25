<?php

use App\Http\Controllers\Feedback\FeedbackController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('feedback')->controller(FeedbackController::class)->group(function () {

    Route::middleware('auth')->group(function () {
        Route::redirect('feedback', '/feedback/list');

        Route::get('/list', function () {
            return Inertia::render('feedback/Feedback');
        })->name('feedback.list');

        Route::post('/', 'store')->name('feedback.store');
    });
});
