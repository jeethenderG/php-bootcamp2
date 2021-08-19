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


Route::post('/users/create', [UsersController::class, 'CreateUser']);//....... add user

Route::get('/users/search', [UsersController::class, 'SearchUser']); //.......search user
//Route::get('/users/{email}', [UsersController::class, 'getuserbyemail']); //.......
//Route::get('/users/{phone}', [UsersController::class, 'getuserbyphone']); //.......get user by phone

Route::get('/users', [UsersController::class, 'GetAllUsers']); //.......get all the users

Route::delete('/users/delete' , [UsersController::class, 'DeleteUser']) ; // ....del user
Route::patch('/users/update/{id}' , [UsersController::class, 'Update']) ; // ....del user
//Route::delete('/users/{name}', [UsersController::class, 'deleteuserbyname']); //.......del user by name
//Route::delete('/users/{email}', [UsersController::class, 'deleteuserbyemail']); //.......del user by email

