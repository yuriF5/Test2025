<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeasonController;


//商品一覧
Route::get('/', [ProductController::class, 'index']);
//検索
Route::get('/search', [ProductController::class, 'index'])->name('search');
// 商品詳細ページ
Route::get('/detail/{product_id}', [ProductController::class, 'detail'])->name('product.detail');
//商品更新

//商品登録画面
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');

// 商品登録処理
Route::post('/register/register',[ProductController::class,'store']);
//削除
Route::delete('/detail/{product}', [ProductController::class,'destroy']);