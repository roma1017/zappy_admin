<?php
require_once '../zappy_admin/DbManager.php';

$db=getDb();

// 商品リストを格納する配列
$products = [];

// フェッチモードを連想配列に設定
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// SQLクエリの準備
$sql = "SELECT itemCode, itemName, category, price FROM items ORDER BY itemCode;";
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
    <title>商品リスト</title>
    <!-- <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style> -->
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h1>商品リスト</h1>
    <?php if (count($products) > 0): ?>
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
                        <?php $url = "register_item_edit.php?itemCode=".$product['itemCode']; ?>
                        <td><a href=<?php echo $url ?>><?php echo htmlspecialchars($product['itemCode'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                        <td><?php echo htmlspecialchars($product['itemName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo number_format($product['price']); ?>円</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>商品が見つかりませんでした。</p>
    <?php endif; ?>
</body>
</html>
