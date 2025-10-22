<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
</head>

<body>
    <h2>ようこそ、<?php echo htmlspecialchars($_SESSION["admin_name"]); ?>さん！</h2>
    <p>管理者画面</p>
    <p><button onclick="location.href='register_item_add.php'">商品登録</button></p>
    <p><button onclick="location.href='check_item.php'">商品リスト→修正</button></p>
    <p><a href="logout.php">ログアウト</a></p> 
</body>

</html>