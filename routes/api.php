<?php

use App\Http\Controllers\API\BazarController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('cms/bazar', [BazarController::class, 'index'])->name('getData.bazar');
Route::post('cms/bazar/create', [BazarController::class, 'store'])->name('tambahData.bazar');
Route::get('cms/bazar/{id}', [BazarController::class, 'showById'])->name('editData.bazar');
Route::put('cms/bazar/update/{id}', [BazarController::class, 'update'])->name('updateData.bazar');
Route::delete('cms/bazar/delete/{id}', [BazarController::class, 'delete'])->name('deleteData.bazar');
