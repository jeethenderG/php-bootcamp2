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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/users/create', [UsersController::class, 'createUser']);//....... add user

Route::get('/search/name/{name}', [UsersController::class, 'getUserByName']); //...Get User By Mail
Route::get('/search/email/{email}', [UsersController::class, 'getUserByEmail']); //...Get User By Mail
Route::get('/search/phone/{phone}', [UsersController::class, 'getUserByPhone']); //.......get user by phone

Route::get('/users', [UsersController::class, 'getAllUsers']); //.......get all the users

Route::patch('/update/{id}', [UsersController::class, 'update']); // ....del user
Route::delete('/delete/name/{name}', [UsersController::class, 'deleteUserByName']); //.......del user by name
Route::delete('/delete/email/{email}', [UsersController::class, 'deleteUserByEmail']); //.......del user by name
Route::delete('/delete/phone/{phone}', [UsersController::class, 'deleteUserByPhone']); //.......del user by email

