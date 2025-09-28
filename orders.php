<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$company_id = $user['company_id'];

// Yeni sipariş ekleme
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_order'])){
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    $stmt = $pdo->prepare("INSERT INTO orders (company_id, user
