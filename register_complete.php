<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['form_data'])) {
    header('Location: register_form.php');
    exit;
}

require_once '../zappy/DbManager.php';

$db=getDb();

$adminid = $_SESSION['form_data']['adminid'];
$name = $_SESSION['form_data']['name'];
$password = $_SESSION['form_data']['password'];

// パスワードをハッシュ化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $db->beginTransaction();

    // ユーザーIDの重複チェック
    $stmt_check = $db->prepare('SELECT COUNT(*) FROM admins WHERE adminId = ?');
    $stmt_check->execute([$adminid]);
    if ($stmt_check->fetchColumn() > 0) {
        throw new Exception('このユーザーIDは既に登録されています。');
    }

    // データの挿入
    $sql = 'INSERT INTO admins (adminId, adminName, loginPassword) VALUES (?, ?, ?)';
    $stmt_insert = $db->prepare($sql);
    $stmt_insert->execute([$adminid, $name,$hashed_password]);

    $db->commit();

    // 登録完了後、セッションデータをクリア
    unset($_SESSION['form_data']);

} catch (Exception $e) {
    $db->rollBack();
    $_SESSION['errors'] = [$e->getMessage()];
    $_SESSION['form_data'] = ['adminid' => $adminid, 'name' => $name];    
    header('Location: register_form.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録完了</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>管理者登録完了</h1>
    <p>管理者登録が完了しました。ご登録ありがとうございます！</p>
    <a href="login.php">ログインページへ</a>
</body>
</html>