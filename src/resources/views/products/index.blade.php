@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class=title_up>
    <span class="title_product">
        @if(request('keyword'))
            "{{ request('keyword') }}"商品一覧
        @else
            商品一覧
        @endif
    </span>
    <a class="" href="{{ route('products.register') }}"><span class="title_r_product">✙商品を追加</span></a>

</div>
    <!-- 検索・表示 -->
<main class="product__wrap">
    <div class="product___flex">
        <!-- 左側（検索フォーム） -->
        <form action="{{ route('products.search') }}" method="GET">
        @csrf
        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}">
        <div class="error__item">
            @error('name')
                <span class="error__message">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">検索</button>

        <!-- 並び替え：価格順 -->
        <label for="sort_by">価格順で表示</label>
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
                <span class="product__content">
                    <a href="{{ route('products.detail', ['productId' => $product->id]) }}">
                        <img class="product__image" width="80%" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    </a>
                    <span class="product__info">
                        <h3 class="product__name">{{ $product->name }}</h3>
                        <span class="product__price">{{ number_format($product->price) }}円</span>
                    </span>
                </span>
            @endforeach
        </span>    
    </div>
    <div class="pagination">
        {{ $products->links() }}
    </div>
</main>
@endsection
