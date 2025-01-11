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
public function detail($id)
{
    $product = Product::find($id);

    $seasons = Season::all();

    return view('detail', compact('product','seasons'));
}

// 詳細ページ更新
public function update(Request $request, $id)
    {
        // 画像ファイルがアップロードされたかどうかをチェック
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $path = $img->store('img', 'public');
            $update_info['image_url'] = $path;
        }

        //更新情報を作成
        $update_info = [
        'name' => $request->name,
        'product_id' => $request->product_id,
        'season_id' => $request->season_id,
        'description' => $request->description
        ];
        if(!empty($path)) $update_info['image_url'] = $path;

        //更新
        $product = Product::find($request->id);
        $product->update($update_info);
        // 商品詳細ページへリダイレクト
        return redirect()->route('product.detail', ['id' => $product->id]);
    }

// 削除
    public function delete($product_id)
    {
        product::find($product_id)->delete();
        return redirect()->back()->with('success','商品を削除しました');
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