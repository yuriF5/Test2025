<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeasonController;

//商品一覧,商品詳細,検索
Route::get('/', [ProductController::class, 'index']);
Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::post('/search', [ProductController::class, 'search'])->name('search');
Route::get('/', [ProductController::class, 'index'])->name('prod.index');
//商品更新

//商品登録

//削除

