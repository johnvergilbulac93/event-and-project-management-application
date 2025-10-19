<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::controller(HomeController::class)->prefix('home')->group(function () {
    Route::get('/events', 'event')->name('home.event');
    Route::get('/projects', 'project')->name('home.project');
    Route::post('/feedbacks', 'feedback')->name('home.feedback');
});
