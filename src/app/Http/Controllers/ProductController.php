<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\RegisterRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // クエリのベース
        $productsQuery = Product::query();

        // キーワード検索（部分一致・完全一致）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $matchType = $request->input('match_type', 'partial');

            if ($matchType === 'exact') {
                $productsQuery->where('name', $keyword);
            } else {
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

        // 商品が見つからない場合のメッセージ
        $message = $products->isEmpty() ? '該当の商品は準備中です' : '';

        return view('products.index', compact('products', 'message'));
    }

// 詳細ページ
public function detail($productId)
{
    // 商品情報を取得
    $product = Product::with('seasons')->findOrFail($productId);

    // 季節情報を取得
    $seasons = Season::all();

    // 更新フォームを表示
    return view('products.detail', compact('product', 'seasons'));
}

public function update(Request $request, $productId)
{
    // $product_id を $products_id に変更して、引数を正しく参照
    $product = Product::with('seasons')->find($productId);

    // 画像ファイルがアップロードされたかどうかをチェック
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $product->image = 'images/' . $filename;
    }

    // 商品情報を更新
    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;

    // 保存
    $product->save();

if ($request->has('season_id') && count($request->season_id) > 0) {
    // 配列として複数のseason_idを渡す
    $product->seasons()->sync($request->season_id);
} else {
    // 季節が選ばれていない場合、現在の季節情報を削除
    $product->seasons()->detach();
}

    // 更新後、商品詳細ページにリダイレクト
    return redirect()->route('products.index')->with('success', '商品を更新しました！');
}

// 削除
    public function destroy($productId)
{
    $product = Product::findOrFail($productId);
    $product->delete();

    return redirect()->route('products.index');
}

// 商品登録画面
    public function register(Request $request)
{

    return view('products.register');
}

// 商品登録処理        
    public function store(Request $request)
{
    $validated = $request->validated();

    // 新しい商品を作成
    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;

    // 画像をアップロード
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $product->image = 'images/' . $filename;
    }

    // 商品を保存
    $product->save();

    // 季節情報がある場合、関連付けを保存
    if ($request->has('season_id')) {
        $product->seasons()->sync($request->season_id); // 中間テーブルに季節IDを保存
    }

    // 登録成功メッセージ
    return redirect()->route('products.register')->with('success', '商品が登録されました！');
}

}