@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
@foreach ($products as $product)
    <div class=title_up>
        <div class=title_product>❝{{ $product->name }}❞の商品一覧</div>
        <a href="{{ '/' }}" class="back-btn">&lt; 戻る</a>
    </div>
@endforeach


<div class="product___flex">
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
</div>

@endsection