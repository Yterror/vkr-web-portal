<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Панель администратора</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="teacher-panel">

    <div class="container">

        <div class="breadcrumbs">

            <a href="index.php">Главная</a>

            <span>→</span>

            <span>Панель администратора</span>

        </div>

        <h1>Панель администратора</h1>

        <p class="panel-description">

            Добро пожаловать,
            <?= htmlspecialchars($_SESSION['user_name']) ?>!

        </p>

        <div class="teacher-grid">

            <div class="teacher-card">

                <h2>Пользователи</h2>

                <p>
                    Просмотр зарегистрированных пользователей.
                </p>

                <a href="admin-users.php" class="btn">
                    Открыть
                </a>

            </div>

            <div class="teacher-card">

                <h2>Опросы</h2>

                <p>
                    Просмотр всех опросов.
                </p>

                <a href="admin-polls.php" class="btn">
                    Открыть
                </a>

            </div>

            <div class="teacher-card">

                <h2>Результаты</h2>

                <p>
                    Просмотр результатов опросов.
                </p>

                <a href="admin-results.php" class="btn">
                    Открыть
                </a>

            </div>

            <div class="teacher-card">

                <h2>Категории</h2>

                <p>
                    Просмотр категорий опросов.
                </p>

                <a href="admin-categories.php" class="btn">
                    Открыть
                </a>

            </div>

        </div>

    </div>

</section>

</main>

<footer>

© 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>