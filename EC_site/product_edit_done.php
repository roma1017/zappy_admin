<?php
require_once 'DbManager.php';

try {
    $db = getDb();

    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $oldImage = $_POST['old_image'];
    $deleteImage = isset($_POST['delete_image']); // チェックありなら true

    $newImageName = $oldImage; //デフォルトは変更なし
    $uploadDir = __DIR__ . '/images/';
    // 新しい画像がアップロードされた場合
    if(!empty($_FILES['image']['name'])) {
        $tmpName = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $newName = uniqid('img_') . '.' . $ext;
        $uploadPath = $uploadDir . $newName;

        if(move_uploaded_file($tmpName, $uploadPath)) {
            // 古い画像があれば削除
            if(!empty($oldImage)) {
                $oldPath = $uploadDir . $oldImage;
                if(file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $newImageName = $newName;
        } else {
            echo "画像のアップロードに失敗しました。<br>";
        }
    }
    // 画像削除チェックがあった場合（アップロードなし時のみ）
    elseif($deleteImage && !empty($oldImage)) {
        $oldPath = $uploadDir . $oldImage;
        if(file_exists($oldPath)) unlink($oldPath);
        $newImageName = null; // DB上もNULLに
    }

    // 商品情報を更新
    $stmt = $db->prepare("UPDATE products SET name = :name, price = :price, image = :image WHERE id = :id");
    $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $stmt->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $stmt->bindValue(':image', $newImageName, PDO::PARAM_STR);
    $stmt->execute();

    echo "商品を更新しました！<br>";
    echo '<a href="product_list.php">商品一覧へ戻る</a>';

} catch (PDOException $e) {
    echo "エラー：" . htmlspecialchars($e->getMessage(), ENT_QUOTES);
}