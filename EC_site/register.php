<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow p-4" style="max-width: 500px; width: 100%">
            <h1 class="mb-4 text-center">会員登録</h1>
            <form method="POST" action="confirm.php" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">名前</label>
                    <input type="text" name="name" class="form-control" placeholder="例：山田 太郎" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">登録ID</label>
                    <input type="text" name="id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">登録パスワード <strong>※８文字以上</strong></label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                </div>
                <div class="mb-3">
                    <label class="form-label">登録パスワード（確認）</label>
                    <input type="password" class="form-control" id="confirm_password" required>
                </div>
                <script>
                    const pass = document.querySelector('input[name="password"]');
                    const confirm = document.getElementById('confirm_password');
                    confirm.addEventListener('input', () => {
                        confirm.setCustomValidity(confirm.value !== pass.value ? 'パスワードが一致しません' : '');
                    });
                </script>
                <div class="mb-3">
                    <label class="form-label">住所</label>
                    <input type="text" name="address" class="form-control" placeholder="○○県○○市○○町○○番地" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">メールアドレス</label>
                    <input type="email" name="email" class="form-control" autocomplete="email" placeholder="○○○○○○@example.com" required>
                    <div class="invalid-feedback">
                        正しいメールアドレスを入力してください。
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">電話番号</label>
                    <input type="tel" name="phone" class="form-control" pattern="[0-9]{2,4}-?[0-9]{2,4}-?[0-9]{3,4}" placeholder="090-1234-5678" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="agree" required>
                    <label class="form-check-label" for="agree">
                        <a href="#">利用規約</a>に同意します
                    </label>
                    <div class="invalid-feedback">同意が必要です。</div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">確認画面へ</button>
                </div>
            </form>
            <script>
                // バリデーション・入力チェック強化
                (() => {
                    'use strict';
                    const forms = document.querySelectorAll('.needs-validation');
                    Array.from(forms).forEach(form => {
                        form,addEventListener('submit', event => {
                            if(!form.checkValidity()){
                                event.preventDefault();
                                event.stopPropagation();
                            }
                        form.classList.add('was-validated');
                        }, false);
                    });
                })();
            </script>
        </div>
    </div>
</body>
</html>
