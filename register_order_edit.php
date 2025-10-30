<?php
require_once '../zappy_admin/DbManager.php';

$db = getDb();

session_start();
// エラーメッセージの初期化
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

// 商品リストから飛んできた場合
if (isset($_GET['id'])) {

    // SQL文を作成（商品IDで絞り込み、1件だけ取得）
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
        o.id = :id";
    $stmt = $db->prepare($sql);

    // :idに値をバインド
    $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_STR);

    // クエリの実行
    $stmt->execute();

    // 対象１件データを取得
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['form_data_order_edit'] = ['id' => $order['id'], 'userId' => $order['userId'], 'userName' => $order['userName'], 'itemCode' => $order['itemCode'], 'itemName' => $order['itemName'], 'piece' => $order['piece'], 'status' => $order['status']];
}

$orderid = isset($_SESSION['form_data_order_edit']['id']) ? $_SESSION['form_data_order_edit']['id'] : '';

$userid = isset($_SESSION['form_data_order_edit']['userId']) ? $_SESSION['form_data_order_edit']['userId'] : '';

$username = isset($_SESSION['form_data_order_edit']['userName']) ? $_SESSION['form_data_order_edit']['userName'] : '';

$itemcode = isset($_SESSION['form_data_order_edit']['itemCode']) ? $_SESSION['form_data_order_edit']['itemCode'] : '';

$itemname = isset($_SESSION['form_data_order_edit']['itemName']) ? $_SESSION['form_data_order_edit']['itemName'] : '';

$piece = isset($_SESSION['form_data_order_edit']['piece']) ? $_SESSION['form_data_order_edit']['piece'] : '';

$status = isset($_SESSION['form_data_order_edit']['status']) ? $_SESSION['form_data_order_edit']['status'] : '';

unset($_SESSION['form_data_order_edit']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ステータス更新</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
    <style>
        #itemcode {
            background-color: #a4a1a1ff;
        }
    </style>
</head>

<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="common-page">
        <div class="form">
            <h2 class="page-title">ステータス更新</h2>
            <br>
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <p class="order_info">受注No :<?php echo htmlspecialchars($orderid, ENT_QUOTES, 'UTF-8'); ?></p>

            <p class="order_info">ユーザーID :<?php echo htmlspecialchars($userid, ENT_QUOTES, 'UTF-8'); ?></p>

            <p class="order_info">ユーザー名 :<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></p>

            <p class="order_info">受注商品コード :<?php echo htmlspecialchars($itemcode, ENT_QUOTES, 'UTF-8'); ?></p>

            <p class="order_info">受注商品名 :<?php echo htmlspecialchars($itemname, ENT_QUOTES, 'UTF-8'); ?></p>

            <p class="order_info">受注数 :<?php echo htmlspecialchars($piece, ENT_QUOTES, 'UTF-8'); ?></p>

            <p class="order_info">ステータス :</p>
            <form action="register_order_edit_confirm.php" method="post">
                <div class="radio-group">
                    <label class="radio_title"> 受付待ち<input type="radio" name="after_status" value=1 <?php if ($status == 1) echo "checked"; ?>></label><br>

                    <label class="radio_title"> 受付登録<input type="radio" name="after_status" value=2 <?php if ($status == 2) echo "checked"; ?>></label><br>

                    <label class="radio_title"> 発送済み<input type="radio" name="after_status" value=3 <?php if ($status == 3) echo "checked"; ?>></label><br>
                </div>

                <input type="hidden" name="orderid" value="<?php echo $orderid; ?>" required readonly>

                <input type="hidden" name="before_status" value="<?php echo $status; ?>" required readonly>
                
                <button id="btn" type="submit">登録</button> 
            </form>
            <p><button onclick="location.href='admin_panel.php'">管理者画面へ</button></p>
        </div>
    </div>
</body>

</html>