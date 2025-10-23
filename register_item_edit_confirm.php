<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register_item_edit.php');
    exit;
}

$itemcode = trim($_POST['itemcode']);
$itemname = trim($_POST['itemname']);
$category = trim($_POST['category']);
$price = trim($_POST['price']);

$errors = [];

// バリデーション
if (empty($itemcode)) {
    $errors[] = '商品コードを入力してください。';
}
if (empty($itemname)) {
    $errors[] = '商品コード名を入力してください。';
}
if (empty($category)) {
    $errors[] = 'カテゴリを入力してください。';
}
if (empty($price)) {
    $errors[] = '金額を入力してください。';
}

// エラーがあった場合はフォームに戻す
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = ['itemcode' => $itemcode, 'itemname' => $itemname, 'category' => $category,  'price' => $price];
    header('Location: register_item_edit.php');
    exit;
}

// 入力内容をセッションに保存
$_SESSION['form_data'] = ['itemcode' => $itemcode, 'itemname' => $itemname,  'category' => $category,  'price' => $price];

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
    <form action="register_item_edit_complete.php" method="post">
        <p>商品コード: <?php echo htmlspecialchars($itemcode, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>商品名: <?php echo htmlspecialchars($itemname, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>カテゴリ: <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>価格: <?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?></p>

        <button type="button" onclick="history.back()">修正する</button>
        <button type="submit">登録する</button>
    </form>
</body>
</html>