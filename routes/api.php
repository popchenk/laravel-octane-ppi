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
Route::patch('account/patch/', 'App\Http\Controllers\Api\Account\EditController@patch');
Route::patch('account/password-update/', 'App\Http\Controllers\Api\Account\PasswordController@patch');
Route::post('translation/store', 'App\Http\Controllers\Api\Translation\TranslationController@store');
Route::get('translation/get', 'App\Http\Controllers\Api\Translation\TranslationController@get');
Route::patch('translation/patch/{id}', 'App\Http\Controllers\Api\Translation\TranslationController@patch');
Route::post('render/store', 'App\Http\Controllers\Api\Render\RenderController@store');
Route::get('render/get', 'App\Http\Controllers\Api\Render\RenderController@get');
Route::post('exam/store', 'App\Http\Controllers\Api\Exam\ExamController@store');
Route::get('exam/get', 'App\Http\Controllers\Api\Exam\ExamController@get');
Route::patch('exam/patch/{id}', 'App\Http\Controllers\Api\Exam\ExamController@patch');
Route::get('exam/get-by-name/{name}', 'App\Http\Controllers\Api\Exam\ExamController@getByName');
Route::patch('render/patch/{id}', 'App\Http\Controllers\Api\Render\RenderController@patch');
Route::post('language/store', 'App\Http\Controllers\Api\Language\LanguageController@store');
Route::get('language/get', 'App\Http\Controllers\Api\Language\LanguageController@get');
Route::post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
Route::post('passwords/reset', 'App\Http\Controllers\Api\Auth\PasswordsController@store');
Route::put('passwords/reset', 'App\Http\Controllers\Api\Auth\PasswordsController@update');
