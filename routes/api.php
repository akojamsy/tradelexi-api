<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\userProfileController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("register", [UserAuthController::class, "register"]);
Route::post("login", [UserAuthController::class, "login"]);

Route::middleware('auth:api')->group(function(){
   Route::post("details", [UserAuthController::class, "details"]);
   Route::get("location", [LocationController::class, "location"]); //route for displaying current location of client
   Route::post("create-profile", [userProfileController::class, "store"]);
   Route::get("user-profile", [userProfileController::class, "show"]);
});