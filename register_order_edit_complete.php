<?php
require_once '../zappy/DbManager.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['form_data_order_edit'])) {
    header('Location: register_item_edit.php');
    exit;
}

$db=getDb();

$order_id = $_SESSION['form_data_order_edit']['id'];
$status = $_SESSION['form_data_order_edit']['status'];

try {
    $db->beginTransaction();

    // ユーザーIDの重複チェック 不要

    // データの挿入
    $sql = 'UPDATE orders SET status = ? WHERE id = ?';

    $stmt_insert = $db->prepare($sql);
    $stmt_insert->execute([$status, $order_id]);

    $db->commit();

    // 登録完了後、セッションデータをクリア
    unset($_SESSION['form_data_order_edit']);

} catch (Exception $e) {
    $db->rollBack();
    $_SESSION['errors'] = [$e->getMessage()];
    $_SESSION['form_data_order_edit'] = ['status' => $status];
    header('Location: register_order_edit.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ステータス更新完了</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>ステータス更新完了</h1>
    <p>ステータス更新が完了しました。</p>
    <a href="check_orders.php">受注商品　管理画面へ戻る</a>
</body>
</html>