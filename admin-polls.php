<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT POLL_ID, POLL_TITLE, POLL_STATUS, POLL_START_DATE, POLL_END_DATE
        FROM polls
        ORDER BY POLL_ID DESC";

$stmt = $pdo->query($sql);
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Опросы</title>
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

        <h1>Опросы</h1>

        <?php foreach ($polls as $poll): ?>

            <div class="teacher-card">

                <h2>
                    <?= htmlspecialchars($poll['POLL_TITLE']) ?>
                </h2>

                <p>
                    Статус: <?= htmlspecialchars($poll['POLL_STATUS']) ?>
                </p>

                <p>
                    Дата начала: <?= htmlspecialchars($poll['POLL_START_DATE']) ?>
                </p>

                <p>
                    Дата окончания: <?= htmlspecialchars($poll['POLL_END_DATE']) ?>
                </p>

            </div>

            <br>

        <?php endforeach; ?>

        <a href="admin.php" class="btn">
            Назад
        </a>

    </div>

</section>

</main>

<footer>
    © 2026 Московский университет им. С.Ю. Витте
</footer>

</body>
</html>