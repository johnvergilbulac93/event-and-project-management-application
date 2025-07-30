<?php

use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware('auth')->controller(ProjectController::class)->prefix('projects')->group(function () {
    Route::redirect('/', 'projects/list');
    Route::get('/list', 'index')->name('project.index');
    Route::get('/', 'create')->name('project.create.index');
    Route::post('/', 'store')->name('project.store');
    Route::get('/{project_id}', 'updateIndex')->name('project.update.index');
    Route::put('/{project_id}', 'update')->name('project.update');
    Route::delete('/{project_id}', 'destroy')->name('project.destroy');


});