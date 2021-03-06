<?php

//namespace App\Http\Controllers;

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

/*
 * Authentication routes
 */
Route::post('/user/create', App\Http\Controllers\Authentication\RegisterController::class);
Route::post('/admin/create', App\Http\Controllers\Authentication\RegisterController::class)->name('admin.create');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
