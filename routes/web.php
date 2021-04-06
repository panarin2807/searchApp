<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    return redirect()->action([LoginController::class, 'showLoginForm']);
});

Route::get('/live', 'ProjectController@search');

Route::middleware(['auth', 'Admin'])->group(function () {
    Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/setting', 'SettingAppController@index')->name('setting');
        Route::get('user/fetch_student', 'UserController@fetch_student');
        Route::get('user/personel','UserController@getPersonel')->name('managePersonel');
        Route::get('user/admin','UserController@getAdmin')->name('manageAdmin');
        Route::resource('user', 'UserController');
        
    });
});

Route::get('importExportView', 'Admin\ImportController@importExportView')->name('importExportView');
Route::post('import', 'Admin\ImportController@import')->name('import');

Route::middleware(['auth', 'user.status'])->group(function () {
    Route::get('/search/', 'SearchController@getSearch')->name('search');
    Route::get('/showGroupReport/{year?}', 'ReportController@showGroupReport')->name('reportGroup');
    Route::get('/showTeacherReport/{year?}', 'ReportController@showTeacherReport')->name('reportTeacher');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user', 'UserController');
    Route::resource('project', 'ProjectController');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['user.status']);

// Route::get('/setting', function () {
//     return view('setting');
// })->name('setting')->middleware(['auth', 'user.status']);
