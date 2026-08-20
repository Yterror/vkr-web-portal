<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT COUNT(*) FROM users";
$stmt = $pdo->query($sql);
$users_count = $stmt->fetchColumn();

$sql = "SELECT COUNT(*) FROM polls";
$stmt = $pdo->query($sql);
$polls_count = $stmt->fetchColumn();

$sql = "SELECT USER_ID, USER_FULL_NAME, USER_EMAIL, USER_ROLE_ID
        FROM users
        ORDER BY USER_ID";

$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT POLL_ID, POLL_TITLE, POLL_STATUS
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

    <title>Панель администратора</title>

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

        <nav>

            <ul class="menu">

                <li><a href="index.php">Главная</a></li>
                <li><a href="polls.php">Опросы</a></li>
                <li><a href="about.php">О нас</a></li>

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="teacher-panel">

    <div class="container">

        <h1>Панель администратора</h1>

        <p class="panel-description">
            Добро пожаловать, <?= htmlspecialchars($_SESSION['user_name']) ?>!
        </p>

        <div class="teacher-grid">

            <div class="teacher-card">

                <h2>Пользователи</h2>

                <p>
                    Всего пользователей:
                    <?= $users_count ?>
                </p>

            </div>

            <div class="teacher-card">

                <h2>Опросы</h2>

                <p>
                    Всего опросов:
                    <?= $polls_count ?>
                </p>

            </div>

        </div>

        <div class="teacher-card" style="margin-top:30px;">

            <h2>Пользователи</h2>

            <?php foreach ($users as $user): ?>

                <p>
                    <?= htmlspecialchars($user['USER_FULL_NAME']) ?>
                    —
                    <?= htmlspecialchars($user['USER_EMAIL']) ?>
                    —
                    Роль: <?= $user['USER_ROLE_ID'] ?>
                </p>

            <?php endforeach; ?>

        </div>

        <div class="teacher-card" style="margin-top:30px;">

            <h2>Опросы</h2>

            <?php foreach ($polls as $poll): ?>

                <p>
                    <?= htmlspecialchars($poll['POLL_TITLE']) ?>
                    —
                    <?= htmlspecialchars($poll['POLL_STATUS']) ?>
                </p>

            <?php endforeach; ?>

        </div>

    </div>

</section>

</main>

<footer>

© 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>