<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$company_slug = $_GET['company'] ?? $user['company_slug'];

// Firma bilgilerini al
$stmt = $pdo->prepare("SELECT * FROM companies WHERE slug=?");
$stmt->execute([$company_slug]);
$company = $stmt->fetch();

// Menü butonları
$menu = [
    'Sipariş Oluştur' => 'orders.php',
    'Cariler' => 'customers.php',
    'Stok' => 'products.php',
    'Ayarlar' => 'settings.php'
];
if($user['role'] == 'admin'){
    $menu['Kullanıcılar'] = 'users.php';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
