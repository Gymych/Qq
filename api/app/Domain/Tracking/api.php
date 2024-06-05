<?php

use App\Domain\Tracking\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TrackingController::class, 'all'])->name('all');
Route::post('/create', [TrackingController::class, 'create'])->name('create');
Route::get('/details', [TrackingController::class, 'details'])->name('details');
Route::post('/update-status', [TrackingController::class, 'updateStatus'])->name('update-status');
