<?php

use App\Http\Controllers\Archives\ArchivesController;
use App\Http\Controllers\Attendance\AttendanceController;
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
    Route::controller(AttendanceController::class)->prefix('attendance')->group(function () {
        Route::redirect('/', 'attendance/list');
        Route::get('/list', 'index')->name('attendance.index');
        Route::get('/{event_id}', 'create')->name('attendance.scanner.index');
        Route::post('/', 'store')->name('attendance.store');
        Route::delete('/{event_id}', 'destroy')->name('attendance.destroy');
        Route::get('/attendees/{event_id}', 'listOfAttendees')->name('list.attendees');
    });
    Route::prefix('feedback')->controller(FeedbackController::class)->group(function () {
        Route::get('/', 'index')->name('feedback.index');
        Route::delete('/{feedback_id}', 'destroy')->name('feedback.destroy');
    });
    Route::prefix('report')->controller(ReportController::class)->group(function () {
        Route::get('/', 'index')->name('barangay-record.report');
        Route::get('/profile-account', 'getProfileAccount')->name('barangay-record.report.profile-account');
        Route::get('/profile-account/export', 'exportProfileAccount')->name('barangay-record.report.profile-account.export');
        Route::get('/feedback', 'getFeedBack')->name('barangay-record.report.feedback');
        Route::get('/feedback/export', 'exportFeedBack')->name('barangay-record.report.feedback.export');
        Route::get('/event', 'getEvent')->name('barangay-record.report.event');
        Route::get('/event/export', 'exportEvent')->name('barangay-record.report.event.export');
        Route::get('/project', 'getProject')->name('barangay-record.report.project');
        Route::get('/project/export', 'exportProject')->name('barangay-record.report.project.export');
        Route::get('/attendance/{event_id}', 'getAttendance')->name('barangay-record.report.attendance');
        Route::get('/attendance/{event_id}/export', 'exportAttendance')->name('barangay-record.report.attendance.export');
    });
    Route::prefix('archives')->controller(ArchivesController::class)->group(function () {
        Route::get('/', 'userArchives')->name('user.archives');
        Route::delete('/{id}', 'destroy')->name('user.archives.destroy');
        Route::patch('/{id}', 'restore')->name('user.archives.restore');
    });
});
