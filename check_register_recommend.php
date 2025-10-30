<?php
require_once '../zappy_admin/DbManager.php';

$db = getDb();

// 商品リストを格納する配列
$products = [];

// フェッチモードを連想配列に設定
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// SQLクエリの準備
$sql = "SELECT recommendation, itemCode, itemName, category, price FROM items ORDER BY itemCode;";
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
    <h1>おすすめ商品登録</h1>
    <p><button onclick="location.href='admin_panel.php'">管理者画面へ戻る</button></p>
    <?php if (count($products) > 0): ?>
        <form action="register_recommend_confirm.php" method="post">
            <p><button type="submit">おすすめ商品登録</button></p>
            <table>
                <thead>
                    <tr>
                        <th>おすすめ商品</th>
                        <th>商品コード</th>
                        <th>商品名</th>
                        <th>カテゴリ</th>
                        <th>価格</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="recommend_checkbox[]" value="<?= $product['itemCode'] ?>" <?php if ($product['recommendation']) { echo 'checked';} ?>>
                            </td>
                            <td><?php echo htmlspecialchars($product['itemCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($product['itemName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo number_format($product['price']); ?>円</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>

    <?php else: ?>
        <p>商品が見つかりませんでした。</p>
    <?php endif; ?>
</body>

</html>