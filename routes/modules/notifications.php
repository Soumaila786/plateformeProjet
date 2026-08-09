<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/toutes-lues', [NotificationController::class, 'marquerToutesLues'])->name('notifications.toutes-lues');
Route::delete('/notifications/lues', [NotificationController::class, 'destroyLues'])->name('notifications.destroy-lues');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
