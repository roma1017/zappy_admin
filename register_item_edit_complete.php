<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['form_data'])) {
    header('Location: register_item_edit.php');
    exit;
}

require_once '../zappy/DbManager.php';

$db=getDb();

$itemcode = $_SESSION['form_data']['itemcode'];
$itemname = $_SESSION['form_data']['itemname'];
$category = $_SESSION['form_data']['category'];
$price = $_SESSION['form_data']['price'];

try {
    $db->beginTransaction();

    // ユーザーIDの重複チェック 不要

    // データの挿入
    $sql = 'UPDATE items SET itemName = ?, category = ?, price= ? WHERE itemCode = ?';

    $stmt_insert = $db->prepare($sql);
    $stmt_insert->execute([$itemname, $category, $price, $itemcode]);

    $db->commit();

    // 登録完了後、セッションデータをクリア
    unset($_SESSION['form_data']);

} catch (Exception $e) {
    $db->rollBack();
    $_SESSION['errors'] = [$e->getMessage()];
    $_SESSION['form_data'] = ['itemcode' => $itemcode, 'itemname' => $itemname, 'category' => $category, 'price' => $price];    
    header('Location: register_item_edit.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品変更完了</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>商品変更完了</h1>
    <p>商品変更が完了しました。</p>
    <a href="check_item.php">商品リストへ</a>
</body>
</html>