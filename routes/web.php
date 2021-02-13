<?php

use App\Http\Controllers\Admin\UserController;
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
    return view('welcome');
});

Route::middleware(['auth', 'Admin'])->group(function () {
    Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/setting','SettingAppController@index')->name('setting');
        Route::resource('user', 'UserController');
    });
});

Route::middleware(['auth', 'user.status'])->group(function () {
    Route::get('/search/','SearchController@getSearch')->name('search');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user', 'UserController');
    Route::resource('project','ProjectController');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['user.status']);

// Route::get('/setting', function () {
//     return view('setting');
// })->name('setting')->middleware(['auth', 'user.status']);
