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

Route::get('/index', function () {
    return view('index');
});

Route::get('/bar', function () {
    return view('bar');
});

Route::get('/column', function () {
    return view('column');
});

Route::get('/heatmap', function () {
    return view('heatmap');
});

Route::get('/pie', function () {
    return view('pie');
});

Route::get('/radial', function () {
    return view('radial');
});
