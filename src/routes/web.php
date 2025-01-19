<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

//商品一覧
Route::get('/', [ProductController::class, 'index']);
//検索
Route::get('/search', [ProductController::class, 'index'])->name('search');
// 商品詳細ページ
Route::get('/detail/{product_id}', [ProductController::class, 'detail'])->name('product.detail');
// 商品更新ルート
Route::post('/update/{product_id}', [ProductController::class, 'update'])->name('product.update');
//商品登録画面
Route::get('/register', [ProductController::class, 'showRegisterForm'])->name('product.register');
// 商品登録処理
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
//削除
Route::delete('/detail/{product_id}', [ProductController::class, 'destroy'])->name('product.destroy');

