<?php

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


//Handles evaluation route
Route::post('/evaluate-expression', 'CalculatorController@evaluate')->name('evaluate-expression');

//Handles rendering of calculator view
Route::view('/', 'calculator')->name('home');