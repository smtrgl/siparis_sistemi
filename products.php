<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
$company_id = $user['company_id'];

// Yeni ürün ekleme
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_product'])){
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stmt = $pdo->prepare("INSERT INTO products (company_id, name, price) VALUES (?,?,?)");
    $stmt->execute([$company_id, $name, $price]);
    $message = "Yeni ürün eklendi!";
}

// Mevcut ürünleri çek
$products = $pdo->prepare("SELECT * FROM products WHERE company_id=? ORDER BY id DESC");
$products->execute([$company_id]);
$products = $products->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ürünler / Stok</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h2>Ürünler / Stok</h2>
    <a href="dashboard.php?company=<?= $user['company_slug'] ?>">Geri</a>
</header>
<div class="container">
<?php if(isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
<h3>Yeni Ürün Ekle</h3>
<form method="POST">
    <input type="text" name="name" placeholder="Ürün Adı" required><br>
    <input type="number" step="0.01" name="price" placeholder="Fiyat" required><br>
    <button type="submit" name="add_product">Ekle</button>
</form>

<h3>Mevcut Ürünler</h3>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Ad</th><th>Fiyat</th></tr>
<?php foreach($products as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= htmlspecialchars($p['name']) ?></td>
    <td><?= $p['price'] ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
</body>
</html>
