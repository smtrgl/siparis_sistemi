<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'global_admin'){
    header("Location: login.php");
    exit;
}

// İçerik güncelleme
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update_index'])){
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $features = $_POST['features'];
    $stmt = $pdo->prepare("INSERT INTO index_content (title,
