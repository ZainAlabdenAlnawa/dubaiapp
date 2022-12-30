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

Route::post("login", [\App\Http\Controllers\UserController::class, "login"]);
Route::post("register", [App\Http\Controllers\UserController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group( function () {
    //All secure URL's
    Route::post("logout", [\App\Http\Controllers\UserController::class, "logout"]);

    // Route::prefix("superadmin")->group(function(){
    //     Route::post("user",[\App\Http\Controllers\SuperAdmin\UsersController::class, "store"]);
    //     Route::get("user",[\App\Http\Controllers\SuperAdmin\UsersController::class, "index"]);
    //     Route::put("user/{id}",[\App\Http\Controllers\SuperAdmin\UsersController::class, "update"]);
    //     Route::delete("user/{id}",[\App\Http\Controllers\SuperAdmin\UsersController::class, "delete"]);

    //     Route::get("userByRole/{role}",[\App\Http\Controllers\SuperAdmin\UsersController::class, "userByRole"]); Route::resource("userAccessRoles","\App\Http\Controllers\UserAccessRolesController");
    // });
    Route::prefix("admin")->group(function () {
        Route::post("user", [\App\Http\Controllers\Admin\UsersController::class, "store"]);
        Route::get("user/", [\App\Http\Controllers\Admin\UsersController::class, "index"]);
        Route::get("user/{id}", [\App\Http\Controllers\Admin\UsersController::class, "info"]);
        Route::put("{id}/user", [\App\Http\Controllers\Admin\UsersController::class, "update"]);
        Route::delete("user/{id}", [\App\Http\Controllers\Admin\UsersController::class, "delete"]);
        Route::get("userByRole/{id}/{role}", [\App\Http\Controllers\Admin\UsersController::class, "userByRole"]);
    });

    Route::resource("products", "\App\Http\Controllers\ProductsController");
    Route::post("product/addUserToProduct/{u}/{p}", [App\Http\Controllers\ProductsController::class, 'addUserToProduct']);
    Route::get("product/user_products/{user_id}", [App\Http\Controllers\ProductsController::class, 'addUserToProduct']);


    Route::get('get_user_profile_info/{u_id}', [App\Http\Controllers\UserController::class, 'get_user_profile_info']);
    Route::post('update_user_profile_info/{u_id}', [App\Http\Controllers\UserController::class, 'update_user_profile_info']);
    Route::post('password-reset/{u_id}', [App\Http\Controllers\UserController::class, 'reset_password_api']);
// });
