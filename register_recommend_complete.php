<?php
require_once '../zappy/DbManager.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['form_data_order_edit'])) {
    header('Location: check_register_recommend.php');
    exit;
}

$db=getDb();

$recommend_itemcode = implode(',', $_POST['recommend_itemCode']);

try {
    $db->beginTransaction();

    // おすすめflg初期化
    $sql = 'UPDATE items SET recommendation = false';
    $stmt_insert = $db->prepare($sql);
    $stmt_insert->execute();

    // データの更新
    $sql = 'UPDATE items SET recommendation = true WHERE itemCode IN ( ? )';
    $stmt_insert = $db->prepare($sql);
    $stmt_insert->execute([$recommend_itemcode]);

    $db->commit();

} catch (Exception $e) {
    $db->rollBack();
    exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>おすすめ商品更新完了</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>おすすめ商品完了</h1>
    <p>おすすめ商品更新が完了しました。</p>
    <a href="check_register_recommend.php">おすすめ商品　管理画面へ戻る</a>
</body>
</html>