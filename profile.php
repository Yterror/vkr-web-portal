<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Личный кабинет</title>

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

    </div>

</header>

<main>

<section class="teacher-panel">

    <div class="container">

        <div class="breadcrumbs">

            <a href="index.php">Главная</a>

            <span>→</span>

            <span>Личный кабинет</span>

        </div>

        <h1>Личный кабинет</h1>

        <p class="panel-description">
            Добро пожаловать,
            <?= htmlspecialchars($_SESSION['user_name']) ?>!
        </p>


        <div class="teacher-grid">


            <div class="teacher-card">

                <h2>Мой профиль</h2>

                <p>
                    Личные данные пользователя.
                </p>

                <a href="profile.php" class="btn">
                    Открыть
                </a>

            </div>


            <div class="teacher-card">

                <h2>Опросы</h2>

                <p>
                    Доступные опросы.
                </p>

                <a href="polls.php" class="btn">
                    Открыть
                </a>

            </div>


            <div class="teacher-card">

                <h2>История</h2>

                <p>
                    Пройденные опросы.
                </p>

                <a href="my-history.php" class="btn">
                    Открыть
                </a>

            </div>


            <div class="teacher-card">

                <h2>Уведомления</h2>

                <p>
                    Уведомления пользователя.
                </p>

                <a href="my-notifications.php" class="btn">
                    Открыть
                </a>

            </div>


            <div class="teacher-card">

                <h2>Мои результаты</h2>

                <p>
                    Результаты пройденных опросов.
                </p>

                <a href="my-results.php" class="btn">
                    Открыть
                </a>

            </div>


        </div>

    </div>

</section>
</section>

</main>

<footer>

© 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>