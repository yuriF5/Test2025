@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>商品登録</h2>

    <label for="name">商品名<span class="required">必須</span></label>
    <input type="text" id="name" name="name" placeholder="New Name" value="{{ old('name', $product->name ?? '') }}" required>

    <label for="price">値段<span class="required">必須</span></label>
    <input type="number" id="price" name="price" placeholder="New price" value="{{ old('price', $product->price ?? '') }}" required>

    <label for="image">商品画像<span class="required">必須</span></label>
    <input type="file" id="image" name="image" accept="image/*" required>
    <div id="image-preview-container" style="display: none;">
        <img id="image-preview" src="" alt="Image preview" style="max-width: 25%; height: auto;">
    </div>

    <label for="seasons">季節<span class="required">必須</span></label><p>複数選択可</p>
    <div id="seasons">
        <label>
            <input type="checkbox" name="seasons[]" value="spring" 
                {{ in_array('spring', explode(',', $product->seasons ?? '')) ? 'checked' : '' }}> 春
        </label>
        <label>
            <input type="checkbox" name="seasons[]" value="summer" 
                {{ in_array('summer', explode(',', $product->seasons ?? '')) ? 'checked' : '' }}> 夏
        </label>
        <label>
            <input type="checkbox" name="seasons[]" value="autumn" 
                {{ in_array('autumn', explode(',', $product->seasons ?? '')) ? 'checked' : '' }}> 秋
        </label>
        <label>
            <input type="checkbox" name="seasons[]" value="winter" 
                {{ in_array('winter', explode(',', $product->seasons ?? '')) ? 'checked' : '' }}> 冬
        </label>
    </div>

    <label for="description">商品の説明<span class="required">必須</span></label>
    <textarea id="description" name="description" required>{{ old('description', $product->description ?? '') }}</textarea>

    <div class="button-container">
        <a href="{{ url('/') }}" class="btn-back">戻る</a>
        <button type="submit">登録</button>
    </div>
</form>
<script>
document.getElementById('image').addEventListener('change', function(event) {
    var file = event.target.files[0]; // 選択されたファイル
    var previewContainer = document.getElementById('image-preview-container');
    var imagePreview = document.getElementById('image-preview');

    // ファイルが選択された場合
    if (file) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            // プレビュー画像を表示
            imagePreview.src = e.target.result;
            previewContainer.style.display = 'block'; // プレビュー表示
        };
        
        reader.readAsDataURL(file); // 画像ファイルを読み込む
    } else {
        previewContainer.style.display = 'none'; // 画像が選択されていない場合、プレビューを非表示
    }
});
</script>

@endsection