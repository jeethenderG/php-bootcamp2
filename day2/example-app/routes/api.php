<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

Route::middleware('auth:api')->get('/users', function (Request $request) {
    return $request->user();
});

Route::post('/members',  [UsersController::class, 'createuser']); //....... add user
Route::delete('/members/{id}',[UsersController::class, 'deleteuser']); //....... delete user
Route::get('/members/{id}',[UsersController::class, 'getuserbyid']); //....... fetch user by id
Route::get('/members',[UsersController::class, 'getallusers']); //....... fetch all users


