@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
@foreach ($products as $product)
    <div class=title_up>
        <div class=title_product>❝{{ $product->name }}❞の商品一覧</div>
        <a href="{{ $backRoute ?? '/' }}" class="back-btn">&lt; 戻る</a>
    </div>
@endforeach

<!-- 検索フォーム -->
    <aside class="search-box">
        <form action="{{ route('search') }}" method="POST">
            @csrf
            <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}">
            <button type="submit">検索</button>
            <label for="price_range">値段で表示</label>
            <select name="price_range" id="price_range">
                <option value="">0円～10,000円</option>
                <option value="0-1000">0円 - 1,000円</option>
                <option value="1001-5000">1,001円 - 5,000円</option>
                <option value="5001-10000">5,001円 - 10,000円</option>
            </select>
        </form>
    </aside>

    <!-- 詳細情報表示 -->
    <article class="product-detail">
        <!-- 商品画像 -->
        @foreach ($products as $product)
        <section class="product-detail-image">
            @if (filter_var($product->image, FILTER_VALIDATE_URL))
                <img class="product-detail__image-img" src="{{ $product->image }}" alt="{{ $product->name }}" width="100%">
            @else
                <img class="product-detail__image-img" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" width="100%">
            @endif
        </section>

        <!-- 商品の価格 -->
        <section class="product-detail-price">
            <p class="product-detail__price-text">{{ number_format($product->price) }}円</p>
        </section>

        <!-- 商品の説明 -->
        <section class="product-detail-outline">
            <p class="product-detail__outline-text">{{ $product->description }}</p>
        </section>
        @endforeach
    </article>

@endsection