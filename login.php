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
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <h2>管理者　ログイン</h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <!-- <div class="container"> -->
        <form method="POST">
            <div class="row m-3">
                <div class="col-5">
                    <label>管理者ID：</label>
                    <input type="text" class="form-control" name="adminid" required placeholder="adminid">

                <div class="col-5">
                    <label>管理者パスワード：</label>
                    <input type="password" class="form-control" name="password" required placeholder="password">
                </div>

                <div class="col-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-sm mt-1">Submit</button>
                </div>
            </div>

            <!-- <div class="col m-3">
                <label>管理者ID：<input type="text" class="form-control" name="adminid" required placeholder="adminid"></label><br>
                <label>管理者パスワード：<input type="password" class="form-control" name="password" required  placeholder="password"></label><br>
                <input type="submit"  class="btn btn-primary m-4" value="ログイン">
            </div> -->
        </form>
    </div>

</body>

</html>