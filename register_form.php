<?php
require_once '../zappy_admin/DbManager.php';

$db=getDb();

session_start();
// エラーメッセージの初期化
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

$adminid = isset($_SESSION['form_data']['adminid']) ? $_SESSION['form_data']['adminid'] : '';
$name = isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : '';

unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者登録</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>管理者登録</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="register_confirm.php" method="post">
        <label for="adminid">管理者ID:</label>
        <input type="text" id="adminid" name="adminId" value="<?php echo htmlspecialchars($adminid, ENT_QUOTES, 'UTF-8'); ?>" required><br>

        <label for="name">管理者名:</label>
        <input type="text" id="name" name="adminName" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" required><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="loginPassword" required><br>

        <label for="password_confirm">パスワード（確認）:</label>
        <input type="password" id="password_confirm" name="loginPassword_confirm" required><br>

        <button type="submit">確認画面へ</button>
    </form>
</body>
</html>