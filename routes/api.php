<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users','API\UserController');
Route::resource('schools', 'API\SchoolsController');
Route::resource('subjects', 'API\SubjectsController');
Route::resource('areas', 'API\AreasController');
Route::resource('components', 'API\ComponentsController');
// Route::get('users', 'API\UserController');