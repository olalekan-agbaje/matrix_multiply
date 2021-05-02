<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatirxMultiplyController;

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

Route::get('/', function () {
    return 'This is an API to multiply two matrices. Developed by Olalekan Agbaje - olalekanagbaje@gmail.com';
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/MultiplyMatrix', [MatirxMultiplyController::class, 'index'])->name('mulitply');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', function () {
    return response()->json([
        'status' => 'Error',
        'message' => 'Unauthenticated',
    ], 401);
});
