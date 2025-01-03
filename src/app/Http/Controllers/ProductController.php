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
        $keyword = $request->input('keyword');
        $matchType = $request->input('match_type', 'partial'); 

        if ($matchType === 'exact') {
            // 完全一致
            $productsQuery->where('name', $keyword);
        } else {
            // 部分一致
            $productsQuery->where('name', 'LIKE', "%$keyword%");
        }
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

    // 商品取得
    $products = $productsQuery->simplePaginate(6);

    // 商品が見つからない場合、エラーメッセージを設定
    $message = $products->isEmpty() ? '該当の商品は準備中です' : '';

    return view('index', compact('products', 'message'));
}


// 検索機能
public function search(Request $request)
{
    $products = $this->searchProducts($request);
    return view('detail', compact('products'));
}

// 詳細ページ
public function detail(Request $request)
{
    $products = Product::all();
    return view('detail', compact('products'));
}

// 商品登録フォームを表示する
public function create()
{
    return view('create');
}


public function store(Request $request)
{
    // バリデーション
    $data = $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|image',
        'seasons' => 'array',
        'seasons.*' => 'string|in:spring,summer,autumn,winter',
        'description' => 'required|string',
    ]);

    // 商品の新規作成
    $product = new Product();
    $product->name = $data['name'];
    $product->price = $data['price'];
    $product->description = $data['description'];

    // seasonsは配列で受け取り、カンマ区切りで保存
    $product->seasons = implode(',', $data['seasons']);

    // 画像の処理
    $path = $request->file('image')->store('images', 'public');
    $product->image = $path;

    // 保存
    $product->save();

    return redirect()->route('create')->with('success', '商品を登録しました');
}

}