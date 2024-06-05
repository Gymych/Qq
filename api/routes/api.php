<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->as('auth:')
    ->group(fn () => require app_path('../Domain/Auth/api.php'));


// Tracking Domain
Route::middleware(['auth:api'])->group(function (): void {
    Route::prefix('tracking')
        ->as('tracking:')
        ->group(fn () => require app_path('../Domain/Tracking/api.php'));
});
