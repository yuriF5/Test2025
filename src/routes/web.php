<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品詳細
Route::get('/products/{productId}', [ProductController::class, 'detail'])->name('products.detail');

// 更新処理を実行
Route::put('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');

// 商品登録画面表示
Route::get('/products/register', [ProductController::class, 'register'])->name('products.register');

// 登録フォーム
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store'); 

// 商品削除
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.delete');