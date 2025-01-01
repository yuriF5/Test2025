@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<main class="container">
    <!-- 検索・フィルタ -->
    <aside class="search-box">
        <h3>商品</h3>
        <input type="text" placeholder="検索...">
        <button>検索</button>
        <h3>価格帯で表示</h3>
        <input type="text" placeholder="検索...">
        <button>検索</button>
    </aside>

    <!-- 製品一覧 -->
    <section class="product-list">
        <article class="product">
            <img src="product1.jpg" alt="製品1">
            <p>製品1</p>
        </article>
        <article class="product">
            <img src="product2.jpg" alt="製品2">
            <p>製品2</p>
        </article>
        <!-- 他の製品をここに追加 -->
    </section>
</main>
@endsection