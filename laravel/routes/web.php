<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/property/{id}', [App\Http\Controllers\PropertyController::class, 'index'])->name('property');

Route::post('/email', [App\Http\Controllers\PropertyController::class, 'email']);

Auth::routes();



Route::group(['middleware' => 'auth'], function() {
    Route::get('/notifications', [App\Http\Controllers\NotificationsController::class, 'index'])->name('notifications');

    Route::get('/create', [App\Http\Controllers\UserPropertyController::class, 'create'])->name('create');
    
    Route::get('/edit-property/{id}', [App\Http\Controllers\UserPropertyController::class, 'edit']);
    
    Route::get('/delete/{id}', [App\Http\Controllers\UserPropertyController::class, 'delete']);
    
    Route::post('/update', [App\Http\Controllers\UserPropertyController::class, 'update']);
    
    Route::post('/post', [App\Http\Controllers\UserPropertyController::class, 'post']);
    
    Route::get('/listings', [App\Http\Controllers\UserPropertyController::class, 'listings'])->name('listings');
    
    Route::post('/save-search', [App\Http\Controllers\SavedSearchController::class, 'save_search']);

    Route::get('/saved-searches', [App\Http\Controllers\SavedSearchController::class, 'saved_searches'])->name('saved');

    Route::post('/update-search/{id}', [App\Http\Controllers\SavedSearchController::class, 'update_search']);
    
    Route::get('/saved-search/{id}', [App\Http\Controllers\SavedSearchController::class, 'get_saved_search']);

    Route::get('/delete-search/{id}', [App\Http\Controllers\SavedSearchController::class, 'delete_search']);

    Route::get('/check-notification', [App\Http\Controllers\NotificationsController::class, 'check_notification']);
});
