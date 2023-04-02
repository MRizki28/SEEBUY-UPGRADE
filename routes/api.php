<?php

use App\Http\Controllers\API\BazarController;
use App\Http\Controllers\AUTH\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::get('/profile', function(Request $request) {
    //     return auth()->user();
    // });


    Route::get('cms/bazar', [BazarController::class, 'index']);
    Route::post('cms/bazar/create', [BazarController::class, 'store']);
    Route::get('cms/bazar/{id}', [BazarController::class, 'showById']);
    Route::put('cms/bazar/update/{id}', [BazarController::class, 'update']);
    Route::delete('cms/bazar/delete/{id}', [BazarController::class, 'delete']);

});




Route::post('/cms/register', [AuthController::class, 'register']);
Route::post('/cms/login', [AuthController::class, 'login']);
Route::get('/cms/verify-email/{email}', [AuthController::class, 'verifyEmail']);