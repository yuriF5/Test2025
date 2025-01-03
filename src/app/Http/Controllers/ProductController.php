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

    // ページネーション
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
public function detail($id)
{
    $product = Product::find($id);
    $season = season::find($id);

    return view('detail', compact('product','season'));
}


public function update(Request $request, $id)
    {
        // 商品を取得
        $product = Product::findOrFail($id);

        // バリデーション（必要に応じて）
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 他のフィールドのバリデーションも追加
        ]);

        // 商品情報を更新
        $product->update($validatedData);

        // 更新後にリダイレクト
        return redirect()->route('product.detail', ['id' => $id])->with('success', '商品が更新されました');
    }

}