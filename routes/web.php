<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;
use inertia\inertia;

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
//auth
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth:web');
//Pages
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/', fn() => inertia::render('dashboard'));
    Route::get('/customers', fn() => inertia::render('customers'));
    Route::get('/feedback', fn() => inertia::render('feedback'));
    Route::get('/menu', fn() => inertia::render('menu'));
//product
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products/create', [ProductController::class, 'store']);
    Route::delete('/product/delete/{product}', [ProductController::class, 'destroy']);
    Route::get('/findTypeByName/{type}', [ProductController::class, 'findTypeByName']);
    Route::get('/findColorImages/{color}', [ProductController::class, 'findColorImages']);
//type
    Route::get('/products/types', [TypeController::class, 'index']);
    Route::get('/products/types/create', [TypeController::class, 'create']);
    Route::post('/products/types/create', [TypeController::class, 'store']);
    Route::delete('/type/delete/{type}', [TypeController::class, 'destroy']);
//category
    Route::get('/products/categories', [CategoryController::class, 'index']);
    Route::get('/products/categories/create', [CategoryController::class, 'create']);
    Route::post('/products/categories/create', [CategoryController::class, 'store']);
    Route::delete('/category/delete/{category}', [CategoryController::class, 'destroy']);
//color
    Route::post('/product/color/create', [ProductController::class, 'colorStore']);
    Route::get('/products/colors/{product}', [ProductController::class, 'createColor']);
//image
    Route::get('/products/images/{color}', [ProductController::class, 'createImage']);
    Route::post('/products/images/create', [ProductController::class, 'imageStore']);

});



