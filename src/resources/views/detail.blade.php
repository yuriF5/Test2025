@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<main>
    <div class=i_button>
    <a href="{{('/') }}" class="s_button">商品一覧</a>&gt;"{{ $product->name }}"
    </div>
    <form method="POST" action="/update" enctype="multipart/form-data">
            @csrf
        <section class="product-update">
            <!-- 左側（画像とアップロード） -->
            <aside class="product-image-section">
                <img class="product__image" width="80%" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                <input type="file" name="image" class="upload-button">
                <p>画像プレビュー</p>
                    <img id="preview" src="" alt="画像プレビュー"style="max-width: 25%; height: auto; display: none;">
                </div>
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
                        <input type="radio" name="season_id" value="{{ $season->id }}" {{ old('season_id', $product->season_id) == $season->id ? 'checked' : '' }}>
                        <span class="radio-btn">{{ $season->name }}</span>
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
                <img class="trash__btn-image" width="40px"src="{{ asset('images/trash-solid.svg') }}"alt="削除">
            </div>
        </footer>
    </form>
    <!-- 成功メッセージ -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
</main>
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        var input = event.target;

        // ファイルが選択されている場合
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block'; // 画像を表示
            };

            reader.readAsDataURL(input.files[0]); // 画像ファイルを読み込む
        }
    });
</script>
>>>>>>> d4fb9ca (Initial commit)
@endsection
