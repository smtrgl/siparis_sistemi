<?php
$host = "localhost";       // Sunucu host
$db   = "DB_ADI";          // Oluşturduğun veritabanı adı
$user = "DB_KULLANICI";    // Veritabanı kullanıcı adı
$pass = "DB_SIFRE";        // Veritabanı şifre
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
