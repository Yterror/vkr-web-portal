<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT USER_ID, USER_FULL_NAME, USER_EMAIL, USER_ROLE_ID
        FROM users
        ORDER BY USER_ID";

$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Пользователи</title>

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

            <span>Пользователи</span>

        </div>

        <h1>Пользователи</h1>

        <div class="teacher-card">

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

        <br>

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