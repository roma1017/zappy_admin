<?php
require_once '../zappy_admin/DbManager.php';

$db=getDb();

session_start();
// エラーメッセージの初期化
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

// 商品リストから飛んできた場合
if(isset($_GET['itemCode'])) {

    // SQL文を作成（商品IDで絞り込み、1件だけ取得）
    $sql = "SELECT * FROM items WHERE itemCode = :itemcode";
    $stmt = $db->prepare($sql);

    // :itemcodeに値をバインド
    $stmt->bindValue(':itemcode', $_GET['itemCode'], PDO::PARAM_STR);

    // クエリの実行
    $stmt->execute();

    // 対象１件データを取得
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $_SESSION['form_data'] = ['itemcode' => $item['itemCode'], 'itemname' => $item['itemName'], 'category' => $item['category'],  'price' => $item['price']];
}

$itemcode = isset($_SESSION['form_data']['itemcode']) ? $_SESSION['form_data']['itemcode'] : '';

$itemname = isset($_SESSION['form_data']['itemname']) ? $_SESSION['form_data']['itemname'] : '';

$category = isset($_SESSION['form_data']['category']) ? $_SESSION['form_data']['category'] : '';

$price = isset($_SESSION['form_data']['price']) ? $_SESSION['form_data']['price'] : '';

unset($_SESSION['form_data']);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品変更</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        #itemcode { background-color: #a4a1a1ff; }
    </style>
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>商品変更</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="register_item_edit_confirm.php" method="post">

        <label for="itemCode">商品コード:</label>
        <input type="text" id="itemcode" name="itemcode" value="<?php echo htmlspecialchars($itemcode, ENT_QUOTES, 'UTF-8'); ?>" required readonly><br>

        <label for="itemName">商品名:</label>
        <input type="text" id="itemname" name="itemname" value="<?php echo htmlspecialchars($itemname, ENT_QUOTES, 'UTF-8'); ?>" required><br>

        <label for="category">商品カテゴリ:</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>" required><br>

        <label for="price">金額:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?>" required><br>
        
        <button type="submit">確認画面へ</button>
    </form>
    <p><button onclick="location.href='admin_panel.php'">管理者画面へ</button></p>
</body>
</html>