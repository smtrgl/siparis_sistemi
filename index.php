<?php
include 'config.php';

// Index içeriğini çek
$content = $pdo->query("SELECT * FROM index_content ORDER BY id DESC LIMIT 1")->fetch();
$plans = $pdo->query("SELECT * FROM subscription_plans")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Takip Sistemi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="index-container">
    <h1><?= htmlspecialchars($content['title'] ?? 'Sipariş Takip Sistemi') ?></h1>
    <h3><?= htmlspecialchars($content['subtitle'] ?? 'Modern ve mobil uyumlu SaaS çözümü') ?></h3>

    <?php if($content['features']): ?>
    <ul>
        <?php
        $features = explode("\n", $content['features']);
        foreach($features as $f): ?>
            <li><?= htmlspecialchars($f) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="plans">
        <?php foreach($plans as $plan): ?>
            <div class="plan-card">
                <h4><?= htmlspecialchars($plan['name']) ?></h4>
                <p>Fiyat: <?= $plan['price'] ?>₺ / <?= $plan['duration_days'] ?> gün</p>
                <p>Maks Kullanıcı: <?= $plan['max_users'] ?></p>
                <p><?= htmlspecialchars($plan['description']) ?></p>
                <a href="register.php?plan_id=<?= $plan['id'] ?>">Kayıt Ol</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
