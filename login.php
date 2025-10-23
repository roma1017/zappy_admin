<?php
require_once '../zappy_admin/DbManager.php';

$db = getDb();

session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $adminid = $_POST["adminid"];
    $password = $_POST["password"];

    $stmt = $db->prepare("SELECT * FROM admins WHERE adminId = :adminid");
    $stmt->execute([':adminid' => $adminid]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    //if ($admin && $password === $admin["loginPassword"]) {
    if ($admin && password_verify($password, $admin["loginPassword"])) {
        $error = "ログイン成功";

        $_SESSION["id"] = $admin["id"];
        $_SESSION["admin_id"] = $admin["adminId"];
        $_SESSION["admin_name"] = $admin["adminName"];
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "管理者IDまたはパスワードが間違っています。";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>管理者　ログイン</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="./script.js"></script>
    <div class="common-page">
        <div class="form">
            <h2 class="page-title">管理者　login</h2>
            <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
            <!-- <div class="container"> -->
            <form class="login-form" method="POST">
                <!-- <label>管理者ID：</label> -->
                <input type="text" name="adminid" required placeholder="adminid">

                <!-- <label>管理者パスワード：</label> -->
                <input type="password" name="password" required placeholder="password">
                <button type="submit">login</button>
            </form>
        </div>
    </div>

</body>

</html>

<!-- <div class="login-page">
  <div class="form">
    <form class="register-form">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>
    <form class="login-form">
      <input type="text" placeholder="username"/>
      <input type="password" placeholder="password"/>
      <button>login</button>
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div> -->