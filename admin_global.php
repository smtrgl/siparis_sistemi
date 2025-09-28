<?php
include 'config.php';
session_start();

// Basit global admin kontrolü
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'global_admin'){
    header("Location: login.php");
    exit;
}

// Firma abonelik güncelleme
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update_subscription'])){
    $company_id = $_POST['company_id'];
    $plan_id = $_POST['plan_id'];
    $stmt = $pdo->prepare("UPDATE companies SET plan_id=?, plan_start=CURDATE(), plan_end=DATE_ADD(CURDATE(), INTERVAL (SELECT duration_days FROM subscription_plans WHERE id=?) DAY) WHERE id=?");
    $stmt->execute([$plan_id, $plan_id, $company_id]);
    $message
