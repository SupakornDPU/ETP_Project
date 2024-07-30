<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/create', [HomeController::class, 'create'])->name('home.create');
    Route::post('/store', [HomeController::class, 'store'])->name('home.store');
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('home.edit');
    Route::post('/update/{id}', [HomeController::class, 'update'])->name('home.update');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('home.delete');
});
