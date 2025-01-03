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


//商品登録画面表示
Route::get('/create',[ProductController::class,'create'])->name('create');

// 商品登録処理
Route::post('/create',[ProductController::class,'store'])->name('product.store');
//削除
Route::delete('/detail/{product}', [ProductController::class,'destroy']);