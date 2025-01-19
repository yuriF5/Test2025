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

    // 並び替え処理（安い高い順）
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
public function detail($products_id)
{
    $product = Product::find($products_id);
    $seasons = Season::all();

    // $products_idを$product_idとしてビューに渡す
    return view('detail', compact('product', 'seasons', 'products_id'));
}

// 商品更新
public function update(Request $request, $products_id)
{
    // $products_idを使って商品を取得
    $product = Product::findOrFail($products_id);

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

    // 季節情報も更新
    $product->season_id = $request->season_id;

    // 保存
    $product->save();

    // 更新後、商品一覧ページにリダイレクト
    return redirect('/')->with('success', '商品を更新しました！');
}


// 削除
    public function destroy($product_id)
{
    $product = Product::findOrFail($product_id);
    $product->delete();

    return redirect('/')->with('success', '商品を削除しました！');
}


// 商品登録画面
    public function showRegisterForm()
{
    $seasons = Season::all();  // 季節を全て取得
    return view('product.register', compact('seasons'));
}

// 商品登録処理        
    public function store(Request $request)
{
    // バリデーション
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'required|image',
        'description' => 'required|string',
        'seasons' => 'required|array',  // 季節は配列として受け取る
        'seasons.*' => 'exists:seasons,id',  // 季節IDがseasonsテーブルに存在することを確認
    ]);

    // 商品情報を保存
    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;
    $product->image = $request->file('image')->store('images', 'public');
    $product->description = $request->description;
    $product->save();

    // 季節情報を中間テーブルに保存
    $product->seasons()->attach($request->seasons);

    return redirect()->route('product.register')->with('success', '商品が登録されました');
}
}