<?php
require_once 'DbManager.php';

try {
    $db = getDb();
    $stmt = $db->query("SELECT * FROM products ORDER BY id ASC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー：" . htmlspecialchars($e->getMessage(), ENT_QUOTES);
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
</head>
<body>
    <h1>商品一覧</h1>
    <p><a href="product_add.php">+ 商品を追加</a></p>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>商品名</th>
            <th>価格</th>
            <th>画像</th>
            <th>登録日時</th>
            <th>操作</th>
        </tr>
        <?php foreach($products as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['id']) ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= htmlspecialchars(number_format($p['price'])) ?> 円</td>
                <td>
                    <?php if(!empty($p['image'])): ?>
                        <img src="images/<?= htmlspecialchars($p['image']) ?>" width="100" height="80" alt="">
                    <?php else: ?>
                        (なし)
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($p['created_at']) ?></td>
                <td>
                    <a href="product_edit.php?id=<?= $p['id'] ?>">編集</a>
                    <a href="product_delete.php?id=<?= $p['id'] ?>">削除</a>
                </td>
            </tr>
            <?php endforeach; ?>
    </table>
</body>
</html>