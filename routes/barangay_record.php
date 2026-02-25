<?php

use App\Http\Controllers\Feedback\FeedbackController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\User\ProfileAccountController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->prefix('barangay-record')->group(function () {
    Route::redirect('barangay-record', '/barangay-record/profile-account');

    Route::prefix('profile-account')->controller(ProfileAccountController::class)->group(function () {
        Route::get('/', 'index')->name('barangay-record.profile-account');
        Route::get('/add-new-profile', 'create')->name('barangay-record.profile-account.create');
        Route::post('/', 'store')->name('barangay-record.profile-account.store');
        Route::get('/{id}', 'updateIndex')->name('barangay-record.profile-account.update.index');
        Route::put('/{id}', 'update')->name('barangay-record.profile-account.update');
        Route::delete('/{id}', 'destroy')->name('barangay-record.profile-account.destroy');
    });
    Route::prefix('feedback')->controller(FeedbackController::class)->group(function () {
        Route::get('/', 'index')->name('barangay-record.feedback');
    });
    Route::prefix('report')->controller(ReportController::class)->group(function () {
        Route::get('/', 'index')->name('barangay-record.report');
    });
});
