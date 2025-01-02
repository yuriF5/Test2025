<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;


class ProductController extends Controller
{
// 検索と一覧表示
public function index(Request $request)
{
    // ベースクエリ
    $productsQuery = Product::query();

    // 最小価格の絞り込み
    if ($request->filled('price_min')) {
        $productsQuery->where('price', '>=', $request->input('price_min'));
    }

    // 最大価格の絞り込み
    if ($request->filled('price_max')) {
        $productsQuery->where('price', '<=', $request->input('price_max'));
    }

    // キーワード検索
    if ($request->filled('keyword')) {
        $productsQuery->where('name', 'like', '%' . $request->input('keyword') . '%');
    }

    // 並び替え処理（価格順）
    $sortBy = $request->input('sort_by');
    if ($sortBy) {
        switch ($sortBy) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
        }
    }

    $products = $productsQuery->simplePaginate(6);

    return view('index', compact('products'));
}


// 検索機能
public function search(Request $request)
{
    $products = $this->searchProducts($request);
    $message = '';
    if ($products->isEmpty()) {
        $message = 'No products found.';
    }
    return view('detail', compact('message', 'products'));
}

// 詳細ページ
public function detail(Request $request)
{
    $product = Product::find($request->product_id);
    $backRoute = route('/');

    // 商品が見つからない場合
    if (!$product) {
        return redirect('/')->with('error', '商品が見つかりません。');
    }

    return view('detail', compact('product', 'backRoute'));
}

// backルート
public function show($id)
{
    $product = Product::findOrFail($id);
    $backRoute = route('index');
    
    return view('product.detail', compact('product', 'backRoute'));
}

}
