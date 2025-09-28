<?php
include 'config.php';
session_start();

$plan_id = $_GET['plan_id'] ?? null;
$plans = $pdo->query("SELECT * FROM subscription_plans")->fetchAll();
$selected_plan = $plan_id ? $pdo->prepare("SELECT * FROM subscription_plans WHERE id=?") : null;
if($selected_plan){
    $selected_plan->execute([$plan_id]);
    $selected_plan = $selected_plan->fetch();
}

// Form gönderimi
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = trim($_POST['name']);
    $company_name = trim($_POST['company_name']);
    $plan_id_post = $_POST['plan_id'];

    // Firma slug oluştur
    $company_slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $company_name));

    // Firma ekle
    $stmt = $pdo->prepare("INSERT INTO companies (name, slug, plan_id, plan_start, plan_end) VALUES (?,?,?,CURDATE(), DATE_ADD(CURDATE(), INTERVAL (SELECT duration_days FROM subscription_plans WHERE id=?) DAY))");
    $stmt->execute([$company_name, $company_slug, $plan_id_post, $plan_id_post]);
    $company_id = $pdo->lastInsertId();

    // Kullanıcı ekle (aktif değil, admin onayı bekliyor)
    $stmt2 = $pdo->prepare("INSERT INTO users (username, password_hash, name, company_id, status) VALUES (?,?,?,?, 'pending')");
    $stmt2->execute([$username, $password, $name, $company_id]);

    $_SESSION['message'] = "Kayıt başarıyla oluşturuldu. Admin onayı bekleniyor.";
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kayıt Ol</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="index-container">
<h1>Kayıt Ol</h1>
<form method="POST">
    <input type="text" name="name" placeholder="Ad Soyad" required><br>
    <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
    <input type="password" name="password" placeholder="Şifre" required><br>
    <input type="text" name="company_name" placeholder="Firma Adı" required><br>

    <select name="plan_id" required>
        <?php foreach($plans as $plan): ?>
        <option value="<?= $plan['id'] ?>" <?= ($plan_id && $plan['id']==$plan_id)?'selected':'' ?>><?= htmlspecialchars($plan['name']) ?> - <?= $plan['price'] ?>₺</option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Kayıt Ol</button>
</form>
<p>Zaten hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
</div>
</body>
</html>
