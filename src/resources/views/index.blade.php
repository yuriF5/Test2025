@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class=title_up>
    <span class=title_product>商品一覧</span>
    <a class="" href="{{ '/' }}"><span class="title_r_product">✙商品を追加</span></a>

</div>
    <!-- 検索・表示 -->
<main class="product__wrap">
    <div class="product___flex">
        <!-- 左側（検索フォーム） -->
        <form action="{{ route('search') }}" method="GET">
        @csrf
        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}">
        <div class="error__item">
            @error('name')
                <span class="error__message">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">検索</button>

        <label for="price_range">価格順で表示</label>
        <select name="price_range" id="price_range">
            <option value="" {{ request('price_range') == '' ? 'selected' : '' }}>0円～10,000円</option>
            <option value="">0円～10,000円</option>
            <option value="0-1000">0円 - 1,000円</option>
            <option value="1001-5000">1,001円 - 5,000円</option>
            <option value="5001-10000">5,001円 - 10,000円</option>
        </select>

        <!-- 並び替え：価格順 -->
        <label for="sort_by">並び替え</label>
            <select name="sort_by" id="sort_by">
                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>価格順（安い順）</option>
                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>価格順（高い順）</option>
            </select>
        </form>

        <!-- 右側（商品一覧） -->
        <span class="product__r">
        @if ($message)
        <p class="error-message">{{ $message }}</p>
        @endif
        
        @foreach ($products as $product)
            <div class="product__content">
                <a class="product__detail" href="{{ route('product.detail', ['id' => $product->id]) }}">
                    <img class="product__image" src="{{ $product->image }}" alt="{{ $product->name }}">
                </a>
            </div>
            <h3 class="product__np">
                <span class="product__name">{{ $product->name }}</span>
                <span class="product__price">{{ number_format($product->price) }}円</span>
            </h3>
        @endforeach
        </span>        
    </div>
    <div class="pagination">
        {{ $products->links() }}
    </div>
</main>
@endsection
