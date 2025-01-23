@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>商品登録</h2>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <label for="name">商品名<span class="required">必須</span></label>
    <input type="text" id="name" name="name" placeholder="商品名を入力" value="{{ old('name', $product->name ?? '') }}" required>
    @if ($errors->has('name'))
        <div class="error-message">{{ $errors->first('name') }}</div>
    @endif

    <label for="price">値段<span class="required">必須</span></label>
    <input type="number" id="price" name="price" placeholder="値段を入力" value="{{ old('price', $product->price ?? '') }}" required>
    @if ($errors->has('price'))
        <div class="error-message">{{ $errors->first('price') }}</div>
    @endif

    <label for="image">商品画像<span class="required">必須</span></label>
    <input type="file" id="image" name="image" accept="image/*" required>
    <div id="image-preview-container" style="display: none;">
        <img id="image-preview" src="" alt="Image preview" style="max-width: 25%; height: auto;">
    </div>
    @if ($errors->has('image'))
        <div class="error-message">{{ $errors->first('image') }}</div>
    @endif

    <label for="seasons">
    季節
    <span class="required">必須</span>
    <span class="optional">複数選択可</span>
    </label>
    <div class="error__item">
        @error('season')
            <span class="error__message">{{ $message }}</span>
        @enderror
    </div>
    <div>
        @foreach($seasons as $season)
            <label>
                <input type="checkbox" name="season_id[]" value="{{ $season->id }}">
                {{ $season->name }}
            </label>
        @endforeach
    </div>
    @if ($errors->has('season_id'))
        <div class="error-message">{{ $errors->first('season_id') }}</div>
    @endif

    <label for="description">商品の説明<span class="required">必須</span></label>
    <textarea id="description" name="description" placeholder="商品説明を入力" required>{{ old('description', $product->description ?? '') }}</textarea>
    @if ($errors->has('description'))
        <div class="error-message">{{ $errors->first('description') }}</div>
    @endif

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