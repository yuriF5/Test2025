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
@section('header')
    <div class=title_up>
        <span class=title_product>商品一覧</span>
        <span class=title_r_product>商品追加</span>
    </div>


@endsection

@section('content')
    <main class="product__wrap">
    @foreach ($products as $product)

        <div class="product__content">
            <a class="product__detail" href="{{ url('/detail/'.$product->id) }}"><img class="product__image" src="{{ $product->image }}" alt="{{ $product->name }}"></a>
        </div>

        <h3 class="product__np">
            <span class="product__name">{{ $product->name }}</span>
            <span class="product__price">{{ number_format($product->price) }}円</span>
        </h3>

    @endforeach
    </main>
@endsection
