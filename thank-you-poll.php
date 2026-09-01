<?php

session_start();

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Опрос завершён</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

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

                <li>
                    <a href="index.php">Главная</a>
                </li>

                <li>
                    <a href="polls.php">Опросы</a>
                </li>

                <li>
                    <a href="about.php">О нас</a>
                </li>

                <li>
                    <a href="feedback.php">Обратная связь</a>
                </li>

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="hero">

    <div class="container">

        <div class="breadcrumbs">

            <a href="index.php">Главная</a>

            <span>→</span>

            <a href="polls.php">Опросы</a>

            <span>→</span>

            <span>Опрос завершён</span>

        </div>

        <h1>
            Спасибо за прохождение опроса!
        </h1>

        <p class="poll-description">

            Ваши ответы успешно отправлены и сохранены в системе.

            Благодарим Вас за участие в оценке качества
            образовательного процесса.

        </p>

        <p class="poll-description">

            Полученные ответы используются для анализа результатов
            и дальнейшего совершенствования образовательного процесса.

        </p>

        <div>

            <a href="polls.php" class="btn">
                Вернуться к опросам
            </a>

            <a href="index.php" class="btn">
                На главную
            </a>

        </div>

    </div>

</section>

</main>

<footer>

    © 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>