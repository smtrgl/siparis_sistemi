<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'global_admin'){
    header("Location: login.php");
    exit;
}

// Kullanıcı performansı
$users = $pdo->query("
    SELECT u.id, u.username, c.name as company, COUNT(o.id) as total_orders 
    FROM users u 
    LEFT JOIN orders o ON u.id=o.user_id 
    LEFT JOIN companies c ON u.company_id=c.id
    GROUP BY u.id
")->fetchAll();
?>
<table border="1">
<tr><th>Kullanıcı</th><th>Firma</th><th>Toplam Sipariş</th></tr>
<?php foreach($users as $u): ?>
<tr>
<td><?= htmlspecialchars($u['username']) ?></td>
<td><?= htmlspecialchars($u['company']) ?></td>
<td><?= $u['total_orders'] ?></td>
</tr>
<?php endforeach; ?>
</table>
