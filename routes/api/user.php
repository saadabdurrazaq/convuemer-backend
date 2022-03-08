<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileUserController;

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

Route::post('user/login', [LoginController::class, 'userLogin'])->name('userLogin');
Route::post('user/register', [RegisterController::class, 'register']);

Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    // authenticated staff routes here 
    Route::get('dashboard', [LoginController::class, 'userDashboard']);
    Route::post('logout', [LoginController::class, 'logoutUser']);
    Route::post('change-password', [ProfileUserController::class, 'changePassword']);
});

Route::middleware(['auth:user-api', 'scopes:user'])->get('/user', function (Request $request) {
    return $request->user();
});
