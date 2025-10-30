<?php
require_once '../zappy_admin/DbManager.php';

$db=getDb();

// 商品リストを格納する配列
$orders = [];

// フェッチモードを連想配列に設定
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// SQLクエリの準備
$sql = "SELECT
  o.id,
  o.userId,
  u.userName,
  o.itemCode,
  i.itemName,
  o.piece,
  o.status
FROM
  orders AS o
INNER JOIN
  users AS u ON o.userId = u.userId
INNER JOIN
  items AS i ON o.itemCode = i.itemCode
WHERE
  o.status != 0
ORDER BY
  o.id;";

$stmt = $db->prepare($sql);

// クエリの実行
$stmt->execute();

// 全件データを取得
$orders = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>受注商品　管理</title>
    <!-- <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style> -->
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h1>受注商品　管理</h1>
    <p><button onclick="location.href='admin_panel.php'">管理者画面へ戻る</button></p>    
    <?php if (count($orders) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>受注NO</th>
                    <th>ユーザーID</th>
                    <th>ユーザー名</th>
                    <th>受注商品コード</th>
                    <th>受注商品名</th>
                    <th>受注数</th>
                    <th>ステータス</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8'); ?></td>                      
                        <td><?php echo htmlspecialchars($order['userId'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['userName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['itemCode'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['itemName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($order['piece'], ENT_QUOTES, 'UTF-8'); ?></td>                       
                        <?php $return_value = match($order['status']) {
                                  '1' => '＊＊受付待ち＊＊',
                                  '2' => '受付済->発送準備中',
                                  '3' => '発送完了',
                              };
                        ?>
                        <?php $url = "register_order_edit.php?id=".$order['id']; ?>
                        <td><a href=<?php echo $url ?>><?php echo $return_value ?></a><td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>オーダー済商品が見つかりませんでした。</p>
    <?php endif; ?>
</body>
</html>
