@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<main>
    <div class=i_button>
    <a href="{{('/') }}" class="s_button">商品一覧</a>&gt;"{{ $product->name }}"
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('product.update', ['product_id' => $product->id]) }}" enctype="multipart/form-data">
            @csrf
        <section class="product-update">
            <!-- 左側（画像とアップロード） -->
            <aside class="product-image-section">
            <img class="product__image" width="50%" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            <input type="file" name="image" id="image" class="upload-button">
            <!-- プレビュー画像の表示エリア -->
            <img id="preview" src="" alt="画像プレビュー" style="max-width: 50%; height: auto; display: none;">
            </aside>

            <!-- 右側（商品名、価格、季節） -->
            <section class="product-info">
                <label for="name">商品名</label>
                <input type="text" id="name" name="name" value="{{ $product->name }}">

                <label for="price">価格</label>
                <input type="number" id="price" name="price" value="{{ $product->price }}">

                <label>季節</label>
                <div class="season-selector">
                    <!-- 季節のデータがない場合 -->
                    @if ($seasons->isEmpty())
                        <label>
                            <input type="radio" name="season_id" value="" checked>
                            <span class="radio-btn">季節のデータなし</span>
                        </label>
                    @else
                        <!-- 季節の選択肢がある場合 -->
                        @foreach($seasons as $season)
                            <label>
                                <input type="checkbox" name="season_id[]" value="{{ $season->id }}" 
                                {{ in_array($season->id, $product->seasons->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <span class="checkbox-btn">{{ $season->name }}</span>
                            </label>
                        @endforeach
                    @endif
                </div>
            </section>
        </section>

        <!-- フッター部分 -->
        <footer class="product-footer">
            <label for="description">商品の説明</label>
            <textarea id="description" name="description">{{ $product->description }}</textarea>

            <div class="footer-buttons">
                <a href="{{('/') }}" class="back-button">戻る</a>
                <button type="submit" class="update-button">変更を保存</button>
            </div>
        </footer>
    </form>
    <form method="POST" action="{{ route('product.destroy', $product->id) }}" style="display: inline; margin-left: auto;">
    @csrf
    @method('DELETE')
        <button type="submit" class="delete-button" onclick="return confirm('本当に削除しますか？')">
            <img class="trash__btn-image" width="10px" src="{{ asset('images/trash-solid.svg') }}" alt="削除">
        </button>
    </form>
</main>
<script>
document.getElementById('image').addEventListener('change', function(event) {
    var file = event.target.files[0]; // 選択されたファイル
    var preview = document.getElementById('preview'); // プレビュー画像用の要素

    // ファイルが選択された場合
    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            // プレビュー画像を表示
            preview.src = e.target.result;
            preview.style.display = 'block'; // プレビューを表示
        };

        reader.readAsDataURL(file); // 画像ファイルを読み込む
    } else {
        preview.style.display = 'none'; // 画像が選択されていない場合、プレビューを非表示
    }
});
</script>
@endsection
