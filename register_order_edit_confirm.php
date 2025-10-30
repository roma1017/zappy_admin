<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register_item_edit.php');
    exit;
}

$order_id = trim($_POST['orderid']);
$before_status = trim($_POST['before_status']);
$after_status = trim($_POST['after_status']);

$errors = [];

// バリデーション
if (empty($after_status)) {
    $errors[] = 'ステータスを選択してください。';
}

// エラーがあった場合はフォームに戻す
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data_order_edit'] = ['id' => $order_id, 'status' => $before_status];
    header('Location: register_order_edit.php');
    exit;
}

// 入力内容をセッションに保存
$_SESSION['form_data_order_edit'] = ['id' => $order_id, 'status' => $after_status];

// ステータス値よりmsgを取得
function getStatusMsg($status){
    $return_msg = match ($status) {
        '1' => '＊＊受付待ち＊＊',
        '2' => '受付済->発送準備中',
        '3' => '発送完了',
    };
    return $return_msg;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>内容確認</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>入力内容確認</h1>
    <form action="register_order_edit_complete.php" method="post">
        <p>受注No: <?php echo htmlspecialchars($order_id, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>更新前ステータス: <?php echo getStatusMsg($before_status); ?></p>
        <p>↓</p>
        <p>更新後ステータス: <?php echo getStatusMsg($after_status); ?></p>

        <button type="button" onclick="history.back()">修正する</button>
        <button type="submit">登録する</button>
    </form>
</body>
</html>