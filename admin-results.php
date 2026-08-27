<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT
            polls.POLL_ID,
            polls.POLL_TITLE,
            COUNT(DISTINCT poll_participants.PART_USER_ID) AS TOTAL_USERS
        FROM polls
        LEFT JOIN poll_participants
            ON polls.POLL_ID = poll_participants.PART_POLL_ID
        GROUP BY polls.POLL_ID, polls.POLL_TITLE
        ORDER BY polls.POLL_ID DESC";

$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Результаты</title>

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

        <div class="breadcrumbs">

            <a href="index.php">Главная</a>

            <span>→</span>

            <a href="admin.php">Панель администратора</a>

            <span>→</span>

            <span>Результаты</span>

        </div>

        <h1>Результаты опросов</h1>

        <?php foreach ($results as $result): ?>

            <div class="teacher-card">

                <h2>
                    <?= htmlspecialchars($result['POLL_TITLE']) ?>
                </h2>

                <p>
                    Участников:
                    <?= $result['TOTAL_USERS'] ?>
                </p>

                <a
                    href="results.php?id=<?= $result['POLL_ID'] ?>"
                    class="btn"
                >
                    Открыть результаты
                </a>

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