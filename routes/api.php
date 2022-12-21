<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'App\Http\Controllers\Api\Auth\RegisterController@store');
Route::post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
Route::post('translation/store', 'App\Http\Controllers\Api\Translation\TranslationController@store');
Route::get('translation/get', 'App\Http\Controllers\Api\Translation\TranslationController@get');
Route::patch('translation/patch/{id}', 'App\Http\Controllers\Api\Translation\TranslationController@patch');
Route::post('language/store', 'App\Http\Controllers\Api\Language\LanguageController@store');
Route::get('language/get', 'App\Http\Controllers\Api\Language\LanguageController@get');
Route::post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
Route::post('passwords/reset', 'App\Http\Controllers\Api\Auth\PasswordsController@store');
Route::put('passwords/reset', 'App\Http\Controllers\Api\Auth\PasswordsController@update');
