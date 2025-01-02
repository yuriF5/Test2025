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
    $productsQuery = Product::query();

    if ($request->filled('price_min')) {
        $productsQuery->where('price', '>=', $request->input('price_min'));
    }
    if ($request->filled('price_max')) {
        $productsQuery->where('price', '<=', $request->input('price_max'));
    }
    if ($request->filled('word')) {
        $productsQuery->where('name', 'like', '%' . $request->input('word') . '%');
    }

    $products = $productsQuery->get(['id', 'name', 'price', 'image']);
    $prod =  Product::simplePaginate(6); // ページネーションを6件ごとに設定

    return view('index', compact('products','prod'));

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

// 検索結果
private function searchProducts(Request $request)
{
    $keyword = $request->input('keyword');
    $priceMin = $request->input('price_min');
    $priceMax = $request->input('price_max');
    $query = Product::query();

    if (!empty($keyword)) {
        $query->where('name', 'like', '%' . $keyword . '%');
    }
    if (!empty($priceMin)) {
        $query->where('price', '>=', $priceMin);
    }
    if (!empty($priceMax)) {
        $query->where('price', '<=', $priceMax);
    }

    return $query->get();
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
