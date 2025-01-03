@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<h2>商品登録</h2>

<form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">商品名</label><p>必須</p>
    <input type="text" id="name" name="name" placeholder="New Name" value="{{ old('name', $product->name) }}" required>
    <label for="price">値段</label><p>必須</p>
    <input type="number" id="price" name="price" placeholder="New price" value="{{ old('price', $product->price) }}" required>

    <label for="image">商品画像</label><p>必須</p>
    <input type="file" id="image" name="image" required>

    <label for="seasons">季節</label><p>必須</p>
    <div>
        <label>
            <input type="checkbox" name="seasons[]" value="spring" 
                {{ in_array('spring', explode(',', $product->seasons)) ? 'checked' : '' }}> 春
        </label>
        <label>
            <input type="checkbox" name="seasons[]" value="summer" 
                {{ in_array('summer', explode(',', $product->seasons)) ? 'checked' : '' }}> 夏
        </label>
        <label>
            <input type="checkbox" name="seasons[]" value="autumn" 
                {{ in_array('autumn', explode(',', $product->seasons)) ? 'checked' : '' }}> 秋
        </label>
        <label>
            <input type="checkbox" name="seasons[]" value="winter" 
                {{ in_array('winter', explode(',', $product->seasons)) ? 'checked' : '' }}> 冬
        </label>
    </div>

    <label for="description">商品の説明</label><p>必須</p>
    <textarea id="description" name="description" required>{{ old('description', $product->description) }}</textarea>

    <a href="{{ route('index') }}" class="btn-back">戻る</a>
    <button type="submit">登録</button>
</form>
@endsection