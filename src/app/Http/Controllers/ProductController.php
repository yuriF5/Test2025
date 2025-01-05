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
}