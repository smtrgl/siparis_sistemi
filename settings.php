<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
$company_id = $user['company_id'];

// Firma bilgilerini çek
$stmt = $pdo->prepare("SELECT * FROM companies WHERE id=?");
$stmt->execute([$company_id]);
$company = $stmt->fetch();

// Logo yükleme
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update_settings'])){
    if(isset($_FILES['logo']) && $_FILES['logo']['error']==0){
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo_name = "logo_".$company_id.".".$ext;
        move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/".$logo_name);
        $stmt = $pdo->prepare("UPDATE companies SET logo=? WHERE id=?");
        $stmt->execute([$logo_name, $company_id]);
    }
    // WhatsApp numarası ve format güncelle
    $whatsapp = $_POST['whatsapp'] ?? '';
    $format = $_POST['format'] ?? '';
    $stmt = $pdo->prepare("UPDATE companies SET whatsapp_number=?, whatsapp_format=? WHERE id=?");
    $stmt->execute([$whatsapp, $format, $company_id]);

    $message = "Ayarlar güncellendi!";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ayarlar</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h2>Ayarlar</h2>
    <a href="dashboard.php?company=<?= $user['company_slug'] ?>">Geri</a>
</header>
<div class="container">
<?php if(isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
<h3>Firma Logosu</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="logo"><br><br>
    <h3>WhatsApp Ayarları</h3>
    <input type="text" name="whatsapp" placeholder="WhatsApp Numarası" value="<?= htmlspecialchars($company['whatsapp_number'] ?? '') ?>"><br>
    <textarea name="format" placeholder="Sipariş Formatı"><?= htmlspecialchars($company['whatsapp_format'] ?? '') ?></textarea><br><br>
    <button type="submit" name="update_settings">Güncelle</button>
</form>
</div>
</body>
</html>
