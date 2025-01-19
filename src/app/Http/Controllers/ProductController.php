<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;

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
    $product = Product::with('seasons')->find($product_id);


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

    // 季節情報が送信されていれば更新
    if ($request->has('season_id') && $request->season_id !== '') {
        // 季節が選ばれている場合のみ、syncで中間テーブル更新
        $product->seasons()->sync([$request->season_id]);
    } else {
        // 季節が選ばれていない場合、現在の季節情報を削除
        $product->seasons()->detach();
    }

    // 更新後、商品一覧ページにリダイレクト
    return redirect()->route('product.detail', ['product_id' => $product->id])->with('success', '商品を更新しました！');
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
    if ($request->has('season_id') && $request->season_id !== '') {
        $product->seasons()->sync([$request->season_id]);
    }

    // 登録成功メッセージ
    return redirect()->route('product.register')
                     ->with('success', '商品が登録されました！');
}

}