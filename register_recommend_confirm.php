<?php
require_once '../zappy_admin/DbManager.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: check_register_recommend.php');
    exit;
}

$db = getDb();

// 商品リストを格納する配列
$products = [];

// フェッチモードを連想配列に設定
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// おすすめにチェックしたitemCode
$recommend_checked = implode(',', $_POST['recommend_checkbox']);

// SQLクエリの準備
$sql = "SELECT itemCode, itemName, category, price FROM items WHERE itemCode IN ( $recommend_checked ) ORDER BY itemCode";
$stmt = $db->prepare($sql);

// クエリの実行
$stmt->execute();

// 全件データを取得
$products = $stmt->fetchAll();

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
    <h1>おすすめ商品　確認</h1>
    <form action="" method="post">
        <button type="button" onclick="history.back()">修正する</button>
        <button type="submit">登録する</button><br>
        <table>
            <thead>
                <tr>
                    <th>商品コード</th>
                    <th>商品名</th>
                    <th>カテゴリ</th>
                    <th>価格</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['itemCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($product['itemName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo number_format($product['price']); ?>円</td>
                        <input type="hidden" name="recommend_itemCode[]" value="<?= $product['itemCode'] ?>">
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</body>

</html>