<?php

use App\Http\Controllers\API\BazarController;
use App\Http\Controllers\AUTH\AuthController;
use Illuminate\Support\Facades\Request;
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



Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::get('/profile', function(Request $request) {
    //     return auth()->user();
    // });

    Route::get('/dashboard', function () {
        return view('backend.bazar');
    });


    Route::get('cms/bazar', [BazarController::class, 'index'])->name('getData.bazar');
    Route::post('/cms/bazar/create', [BazarController::class, 'store'])->name('tambahData.bazar');
    Route::get('cms/bazar/{id}', [BazarController::class, 'showById'])->name('editData.bazar');
    Route::put('cms/bazar/update/{id}', [BazarController::class, 'update'])->name('updateData.bazar');
    Route::delete('cms/bazar/delete/{id}', [BazarController::class, 'delete'])->name('deleteData.bazar');



});

Route::get('/', function () {
    return view('backend.login');
})->name('login.bazar');

Route::get('/register', function () {
    return view('backend.register');
})->name('register.bazar');



//auth
Route::post('/cms/register', [AuthController::class, 'register'])->name('registerAdmin.bazar');
Route::post('/cms/login', [AuthController::class, 'login'])->name('loginAdmin.bazar');
Route::post('/cms/verify-email/{email}', [AuthController::class, 'verifyEmail']);

