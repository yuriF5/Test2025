@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<main>
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <section class="product-update">
            <!-- 左側（画像とアップロード） -->
            <aside class="product-image-section">
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="product-image">
                <input type="file" name="image" class="upload-button">
            </aside>

            <!-- 右側（商品名、価格、季節） -->
            <section class="product-info">
                <label for="name">商品名</label>
                <input type="text" id="name" name="name" value="{{ $product->name }}">

                <label for="price">価格</label>
                <input type="number" id="price" name="price" value="{{ $product->price }}">

                <label>季節</label>
                @forelse($product->seasons as $season)
        <li>{{ $season->name }} (Created at: {{ $season->pivot->created_at }}, Updated at: {{ $season->pivot->updated_at }})</li>
    @empty
        <li>季節なし</li>  <!-- seasons が空の場合に表示 -->
    @endforelse
            </section>
        </section>

        <!-- フッター部分 -->
        <footer class="product-footer">
            <label for="description">商品の説明</label>
            <textarea id="description" name="description">{{ $product->description }}</textarea>
            <div class="footer-buttons">
                <a href="{{ route('index') }}" class="back-button">戻る</a>
                <button type="submit" class="update-button">更新</button>
            </div>
        </footer>
    </form>
    <!-- 成功メッセージ -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
</main>
@endsection
