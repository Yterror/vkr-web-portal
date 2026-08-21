<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT * FROM polls
        WHERE POLL_STATUS = 'Активен'
        ORDER BY POLL_ID DESC";

$stmt = $pdo->query($sql);

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Мои опросы</title>

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

        <h1>Доступные опросы</h1>

        <?php foreach ($polls as $poll): ?>

            <div class="teacher-card">

                <h2>
                    <?= htmlspecialchars($poll['POLL_TITLE']) ?>
                </h2>

                <p>
                    <?= htmlspecialchars($poll['POLL_DESCRIPTION']) ?>
                </p>

                <a
                    href="poll.php?id=<?= $poll['POLL_ID'] ?>"
                    class="btn"
                >
                    Пройти опрос
                </a>

            </div>

            <br>

        <?php endforeach; ?>

    </div>

</section>

</main>

<footer>
© 2026 Московский университет им. С.Ю. Витте
</footer>

</body>

</html>