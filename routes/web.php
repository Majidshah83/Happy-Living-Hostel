<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('/login');
});

// Dashboard Routes

Route::get('/logout','Admin\AdminController@logout');
Auth::routes();

Route::get('/clear_cache', function () {
    $exitCode = Artisan::call('optimize:clear');
    return 'Cleared!';
});

Route::get('/storage-link', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'cleared';
});
