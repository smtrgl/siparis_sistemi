<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
$company_id = $user['company_id'];

// Yeni cari ekleme
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_customer'])){
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $stmt = $pdo->prepare("INSERT INTO customers (company_id, name, phone) VALUES (?,?,?)");
    $stmt->execute([$company_id, $name, $phone]);
    $message
