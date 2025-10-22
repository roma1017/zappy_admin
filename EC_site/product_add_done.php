<?php
require_once 'DbManager.php';

try {
    $db = getDB();

    $name = $_POST['name'];
    $price = $_POST['price'];

    $imageName = null;

    //画像がアップロードされた場合
    if(!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/images/';
        $tmpName = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);

        //保存ファイルをユニークに
        $newName = uniqid('img_') . '.' . $ext;
        $uploadPath = $uploadDir . $newName;

        if(move_uploaded_file($tmpName, $uploadPath)) {
            $imageName = $newName;
        } else {
            echo "画像のアップロードに失敗しました。<br>";
        }
    }

    $stmt = $db->prepare("INSERT INTO products (name, price, image) VALUES (:name, :price, :image)");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':price', $price, PDO::PARAM_INT);
    $stmt->bindValue(':image', $imageName, PDO::PARAM_STR);
    $stmt->execute();

    echo "商品を登録しました！<br>";
    echo '<a href="product_list.php">商品一覧へ</a>';

} catch (PDOException $e) {
    echo "エラー：" . htmlspecialchars($e->getMessage(), ENT_QUOTES);
}