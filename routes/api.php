<?php

use App\Http\Controllers\GetFirstQuotesController;
use App\Http\Controllers\RefreshQuotesController;
use App\Http\Middleware\ApiAuthentication;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiAuthentication::class])
    ->name('api.')
    ->group(function () {
        Route::get('/quotes', GetFirstQuotesController::class)
            ->name('quotes');
        Route::get('refresh', RefreshQuotesController::class)
            ->name('refresh');
    });
