<?php
require_once 'DbManager.php';

$id = $_GET['id'] ?? 0;

try {
    $db = getDb();
    $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product) {
        echo "商品が見つかりません。";
        exit;
    }

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
    <title>商品削除確認</title>
</head>
<body>
    <h1>商品削除確認</h1>

    <p>以下の商品を削除しますか？</p>

    <ul>
        <li>ID：<?= htmlspecialchars($product[('id')]) ?></li>
        <li>商品名：<?= htmlspecialchars($product[('name')]) ?></li>
        <li>価格：<?= htmlspecialchars(number_format($product[('price')])) ?> 円</li>
    </ul>

    <form action="product_delete_done.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
        <input type="submit" value="削除する">
    </form>
    <p><a href="product_list.php">キャンセル</a></p>
</body>
</html>