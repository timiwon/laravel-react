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

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/cms', function () {
    return view('cms');
});*/
Route::get('/cms/{path?}', function () {
    return view('cms');
})->where('path', '[a-zA-Z0-9-/]+');
