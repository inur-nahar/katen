<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


Route::middleware('auth')->group(function(){
    Route::controller(profileController::class)->group(function(){
        Route::get('/profile','profile')->name('profile')->middleware('auth');
        Route::put('/update','update')->name('profile.update');
        Route::put('/change-password','changePassword')->name('changePassword');
    });

Route::prefix('/backend/categories')->controller(CategoryController::class)->name('category.')->group(function(){
//Index
Route::get('/','index')->name('index');
//store
Route::post('/store','store')->name('store');
//view
//edit
Route::get('/edit/{id}','edit')->name('edit');
//update
Route::put('/update/{id}','update')->name('update');
//delete
Route::delete ('/delete/{id}','delete')->name('delete');
});

Route::prefix('/backend/subcategories')->controller(SubCategoryController::class)->name('subcategory.')->group(function(){
    //Index
    Route::get('/','index')->name('index');
    //store
    Route::post('/store','store')->name('store');
    //view
    //edit
    Route::get('/edit/{id}','edit')->name('edit');
    //update
    Route::put('/update/{id}','update')->name('update');
    //delete
    Route::delete ('/delete/{id}','delete')->name('delete');
    Route::get('/get-subcategory-by-category','getSubcategory')->name('getSubcategory');
    });

    Route::prefix('/backend/posts')->controller(PostController::class)->name('post.')->group(function(){
        //Index
        Route::get('/','index')->name('index');
        //create
        Route::get('/create','create')->name('create');
        //store
        Route::post('/store','store')->name('store');
        //view
        Route::post('/show','show')->name('show');
        //edit
        Route::get('/edit/{id}','edit')->name('edit');
        //update
        Route::put('/update/{id}','update')->name('update');
        //delete
        Route::delete('/delete/{id}','delete')->name('delete');
        Route::get('/change-status','change_status')->name('change_status');
        Route::get('/change-feature','change_feature')->name('change_feature');

        });


});


