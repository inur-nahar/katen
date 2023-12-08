<?php

use App\Http\Controllers\FrontendHomeController;
use Illuminate\Support\Facades\Route;
Route::get('/', [FrontendHomeController::class,'index'])->name('home');
Route::get('/category/{slug}', [FrontendHomeController::class,'category'])->name('category');
Route::get('/post-show/{slug}', [FrontendHomeController::class,'showPost'])->name('showPost');

