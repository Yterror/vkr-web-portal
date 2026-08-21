<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT * FROM notifications
        WHERE NOT_USER_ID = ?
        ORDER BY NOT_DATE DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);

$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Уведомления</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <div class="container">

        <div class="logo">
            <a href="index.php">
                <span>МУИВ</span>
                <small>Web-портал опросов</small>
            </a>
        </div>

    </div>

</header>

<main>

<section class="teacher-panel">

    <div class="container">

        <h1>Уведомления</h1>

        <?php if (count($notifications) > 0): ?>

            <?php foreach ($notifications as $notification): ?>

                <div class="teacher-card">

                    <p>
                        <?= htmlspecialchars($notification['NOT_TEXT']) ?>
                    </p>

                    <p>
                        <?= htmlspecialchars($notification['NOT_DATE']) ?>
                    </p>

                </div>

                <br>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="teacher-card">
                <p>Уведомлений пока нет.</p>
            </div>

        <?php endif; ?>

    </div>

</section>

</main>

<footer>
© 2026 Московский университет им. С.Ю. Витте
</footer>

</body>

</html>