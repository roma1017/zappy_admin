<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register_form.php');
    exit;
}

$adminid = trim($_POST['adminId']);
$name = trim($_POST['adminName']);
$password = $_POST['loginPassword'];
$password_confirm = $_POST['loginPassword_confirm'];

$errors = [];

// バリデーション
if (empty($adminid)) {
    $errors[] = 'ユーザーIDを入力してください。';
}
if (empty($name)) {
    $errors[] = '名前を入力してください。';
}
if (empty($password)) {
    $errors[] = 'パスワードを入力してください。';
} elseif (strlen($password) < 4) {
    $errors[] = 'パスワードは4文字以上で入力してください。';
}
if ($password !== $password_confirm) {
    $errors[] = 'パスワードが一致しません。';
}

// エラーがあった場合はフォームに戻す
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = ['adminrid' => $adminid, 'name' => $name];
    header('Location: register_form.php');
    exit;
}

// 入力内容をセッションに保存
$_SESSION['form_data'] = ['adminid' => $adminid, 'name' => $name, 'password' => $password];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>内容確認</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <h1>入力内容確認</h1>
    <form action="register_complete.php" method="post">
        <p>管理者ID: <?php echo htmlspecialchars($adminid, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>管理者名: <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>※パスワードは表示されません。</p>

        <button type="button" onclick="history.back()">修正する</button>
        <button type="submit">登録する</button>
    </form>
</body>
</html>