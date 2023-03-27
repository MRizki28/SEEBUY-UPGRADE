<?php

use App\Http\Controllers\API\BazarController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function() {
    return view('backend.bazar');
});



Route::get('cms/bazar', [BazarController::class, 'index'])->name('getData.bazar');
Route::post('cms/bazar/create', [BazarController::class, 'store'])->name('tambahData.bazar');
Route::get('cms/bazar/{id}', [BazarController::class, 'showById']);
Route::put('cms/bazar/update/{id}', [BazarController::class, 'update']);
Route::delete('cms/bazar/delete/{id}', [BazarController::class, 'delete'])->name('deleteData.bazar');

