<?php
require_once 'DbManager.php';

$id = $_POST['id'] ?? 0;

try {
    $db = getDB();

    //　対象商品の画像ファイル名を取得
    $stmt = $db->prepare("SELECT image FROM products WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product) {
        echo "商品が見つかりません。";
        exit;
    }

    // 画像がある場合は削除
    if(!empty($product['image'])) {
        $filePath = __DIR__ . '/images/' . $product['image'];
        if(file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // 商品データを削除
    $stmt = $db->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $stmt->execute();

    echo "商品を削除しました！<br>";
    echo '<a href="product_list.php">商品一覧へ</a>';

} catch (PDOException $e) {
    echo "エラー：" . htmlspecialchars($e->getMessage(), ENT_QUOTES);
}