<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware("auth")->group(function(){
    Route::get("profile", [App\Http\Controllers\UserController::class, 'profile_page']);

    Route::middleware("role:0")->group(function(){
    Route::resource("products", "\App\Http\Controllers\ProductsController");

        Route::get("products", [App\Http\Controllers\ProductsController::class, 'index_view']);
        Route::delete("products/{id}/delete", [App\Http\Controllers\ProductsController::class, 'delete']);

        Route::get("addUserToProduct/{product}", [App\Http\Controllers\ProductsController::class, 'addUserToProductPage']);

        Route::get("admin/users", [App\Http\Controllers\Admin\UsersController::class, 'index_users']);

        Route::get("admin/user/create", [App\Http\Controllers\Admin\UsersController::class, 'create']);


    });
    Route::get("products/view/user", [App\Http\Controllers\ProductsController::class, 'index_user']);

});