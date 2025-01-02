@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<main class="container">
    <h1>商品一覧</h1>
    <!-- 検索・フィルタ -->
    <aside class="search-box">
        <input type="text" placeholder="検索...">
        <button>検索</button>

        <label for="price-range">価格順で表示:</label>
        <select id="price-order" name="price-order">

        </select>

    </aside>

    <!-- 製品一覧 -->
    <section class="product-list">
        <article class="product">
            <img src="product1.jpg" alt="製品1">
            <p>製品1</p>
        </article>
        <article class="product">
            <img src="" alt="製品2">
            <p>製品2</p>
        </article>
        <!-- 他の製品をここに追加 -->
    </section>
</main>
@endsection