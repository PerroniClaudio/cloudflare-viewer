<?php

use App\Http\Controllers\R2BrowserController;
use App\Http\Controllers\R2ConnectionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/connections');

Route::resource('connections', R2ConnectionController::class);
Route::get('connections/{connection}/browse', [R2BrowserController::class, 'index'])
    ->name('connections.browse');
Route::get('connections/{connection}/download', [R2BrowserController::class, 'download'])
    ->name('connections.download');
