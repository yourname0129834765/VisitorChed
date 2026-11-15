<?php

use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VisitorController::class, 'index'])->name('home');

Route::resource('visitors', VisitorController::class);

Route::fallback(function () {
    return redirect()->route('visitors.index');
});
