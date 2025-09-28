<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin'){
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
$company_id = $user['company_id'];

// Kullanıcı ekleme
if(isset($_POST['add_user'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $stmt = $pdo->prepare("INSERT INTO users (company_id, username, password, role) VALUES (?,?,?,?)");
    $stmt->execute([$company_id, $username, $password, $role]);
    $message = "Yeni kullanıcı eklendi!";
}

// Mevcut kullanıcılar
$users = $pdo->prepare("SELECT * FROM users WHERE company_id=?");
$users->execute([$company_id]);
$users = $users->fetchAll();
?>
