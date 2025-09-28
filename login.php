<?php
include 'config.php';
session_start();

// Form gönderimi
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT u.*, c.slug as company_slug, c.plan_end FROM users u JOIN companies c ON u.company_id=c.id WHERE u.username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password_hash'])){
        if($user['status'] !== 'active'){
            $error = "Hesabınız aktif değil veya onay bekliyor.";
        } elseif($user['plan_end'] < date('Y-m-d')){
            $error = "Firmanızın aboneliği bitmiş. Lütfen global admin ile iletişime geçin.";
        } else {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php?company=".$user['company_slug']);
            exit;
        }
    } else {
        $error = "Kullanıcı adı veya şifre hatalı.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Giriş Yap</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="index-container">
<h1>Giriş Yap</h1>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
    <input type="password" name="password" placeholder="Şifre" required><br>
    <button type="submit">Giriş Yap</button>
</form>
<p>Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
</div>
</body>
</html>
