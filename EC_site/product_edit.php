<?php
require_once 'DbManager.php';

$id = $_GET['id'] ?? 0;

try {
    $db =getDb();
    $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product) {
        echo "商品が見つかりません。";
        exit;
    }

} catch(PDOException $e) {
    echo "エラー：" . htmlspecialchars($e->getMessage(), ENT_QUOTES);
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編集</title>
</head>
<body>
    <h1>商品編集</h1>

    <form action="product_edit_done.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($product['image']) ?>">

        <p>商品名：<input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required></p>
        <p>価格：<input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>" required></p>

        <p>現在の画像：<br>
            <?php if(!empty($product['image'])): ?>
                <img src="images/<?= htmlspecialchars($product['image']) ?>" width="100" alt=""><br>
            <label><input type="checkbox" name="delete_image" value="1">画像を削除する</label>    
            <?php else: ?>
                (なし)
            <?php endif; ?>        
        </p>

        <p>新しい画像をアップロード（任意）：<br>
            <input type="file" name="image">
        </p>            

        <p><input type="submit" value="更新する"></p>
    </form>

    <p><a href="product_list.php">商品一覧に戻る</a></p>
</body>
</html>