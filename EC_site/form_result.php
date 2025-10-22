<?php
require_once 'DbManager.php';

try {
    $db = getDb();

    $stt= $db->prepare('INSERT INTO users(name, userid, password, address, email, phone) VALUE(:name, :userid, :password, :address, :email, :phone)');
    $stt->bindValue(':name', $_POST['name']);
    $stt->bindValue(':name', $_POST['id']);
    $stt->bindValue(':name', $_POST['password']);
    $stt->bindValue(':address', $_POST['address']);
    $stt->bindValue(':email', $_POST['email']);
    $stt->bindValue(':phone', $_POST['phone']);

    $stt->execute();
    // 処理後は入力フォームにリダイレクト
    // header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/register.php');
} catch(PDOException $e) {
    die("エラーメッセージ：{$e->getMessage()}");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録完了</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow p-4" style="max-width: 500px; width: 100%">
            <h1 class="mb-4 text-center">会員登録完了</h1>
            
                <div class="mb-3">
                    <label class="form-label">名前:</label>
                    <?= $_POST['name'] ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">登録ID:</label>
                    <?= $_POST['id'] ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">登録パスワード:</label>
                    <?= $_POST['password'] ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">住所:</label>
                    <?= $_POST['address'] ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">メールアドレス:</label>
                    <?= $_POST['email'] ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">電話番号:</label>
                    <?= $_POST['phone'] ?>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary"><a style="color:#fff;" href="register.php">戻る</a></button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
