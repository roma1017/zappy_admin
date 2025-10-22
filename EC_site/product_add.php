<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録</title>
    <style>
        img.preview {
            max-width: 200px;
            margin-top: 10px;
            display: none;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 5px;
        }
        .btn-reset {
            display: none; /* 初期は非表示 */
            margin-top: 8px;
            background: #ddd;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-reset:hover {
            background: #ccc;
        }
    </style>
</head>
<body>
    <h1>商品登録フォーム</h1>

    <form action="product_add_done.php" method="post" enctype="multipart/form-data">
        <p>商品名：<input type="text" name="name" required></p>
        <p>価格：<input type="number" name="price" required></p>
        <p>
            商品画像：<input type="file" name="image" accept="image/*" id="imageInput">
            <br>
            <img id="preview" class="preview" alt="プレビュー画像">
            <br>
            <button type="button" id="resetBtn" class="btn-reset">選択解除</button>
        </p>
        <p><input type="submit" value="登録"></p>
    </form>

    <p><a href="product_list.php">一覧に戻る</a></p>

    <script>
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const resetBtn = document.getElementById('resetBtn');

        // ファイル洗濯時にプレビュー表示
        document.getElementById('imageInput').addEventListener('change', function(event){
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    resetBtn.style.display = 'inline-block'; // 再表示
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });

        // 選択解除ボタンでリセット
        resetBtn.addEventListener('click', function() {
            input.value = '';
            resetPreview();
        });

        // プレビュー消去関数
        function resetPreview() {
            preview.src = '';
            preview.style.display = 'none';
            resetBtn.style.display = 'none';
        }
    </script>
</body>
</html>