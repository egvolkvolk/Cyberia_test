<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//guest
Route::post('/login', [LoginController::class, 'login']); // авторизация
Route::get('/categories', [CategoryController::class, 'index']); // просмотр категорий товаров
Route::get('/products', [ProductController::class, 'index']); // просмотр товаров


//auth
Route::middleware('auth:sanctum')->group(function (){
    Route::get('users/{user}', [UserController::class, 'profile']); // профиль покупателя


    //only user
    Route::middleware('ability:ability:user')->group(function (){
        Route::post('/order/create', [OrderController::class, 'create']); // создание заказа
    });


    //only admin
    Route::middleware('ability:ability:admin')->group(function (){
        Route::get('/orders', [OrderController::class, 'index']); // просмотр заказов
        Route::put('/order/{order}/changeStatus', [OrderController::class, 'changeStatus']); // изменение статуса заказа
    });
});


