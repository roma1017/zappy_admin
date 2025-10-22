<?php
// 入力データを受け取る
if($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: register.php');
    exit();
}

$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
$address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>入力内容の確認</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow p-4" style="max-width: 500px; width:100%">
            <h1 class="mb-4 text-center">入力内容の確認</h1>

            <form action="complete.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">名前：</label><strong><?= $name ?></strong>
                    <input type="hidden" name="name" value="<?= $name ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">登録ID：</label><strong><?= $id ?></strong>
                    <input type="hidden" name="id" value="<?= $id ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">登録パスワード：</label><strong><?= $password ?></strong>
                    <input type="hidden" name="password" value="<?= $password ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">住所：</label><strong><?= $address ?></strong>
                    <input type="hidden" name="address" value="<?= $address ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">メールアドレス：</label><strong><?= $email ?></strong>
                    <input type="hidden" name="email" value="<?= $email ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">電話番号：</label><strong><?= $phone ?></strong>
                    <input type="hidden" name="phone" value="<?= $phone ?>">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="javascript:history.back()" class="btn btn-secondary" style="max-width: 150px; width:100%">修正</a>
                    <button type="submit" class="btn btn-primary" style="max-width: 150px; width:100%">登録</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>