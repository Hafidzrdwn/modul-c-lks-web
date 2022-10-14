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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/products', 'ProdukController@index');
Route::get('/kirims', 'KirimController@index');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/customers', 'CustomerController@index');
    Route::get('/customers/{customer:idCustomer}', 'CustomerController@getOrders');

    Route::middleware('isAdmin')->group(function () {
        Route::post('/products', 'ProdukController@store');
        Route::get('/products/{product:idProduk}', 'ProdukController@edit');
        Route::put('/products/{product:idProduk}', 'ProdukController@update');
        Route::delete('/products/{product:idProduk}', 'ProdukController@destroy');

        Route::get('/categories', 'KategoriController@index');
        Route::post('/categories', 'KategoriController@store');
        Route::get('/categories/{kategori:idKategori}', 'KategoriController@edit');
        Route::put('/categories/{kategori:idKategori}', 'KategoriController@update');
        Route::delete('/categories/{kategori:idKategori}', 'KategoriController@destroy');
    });

    Route::post('/orders', 'OrderController@store');
    Route::post('/order_details', 'OrderDetailController@store');
});

Route::post('/register', 'AuthController@registration');
Route::post('/login', 'AuthController@login');
Route::get('/checkAuth', 'AuthController@checkAuth');
Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');
