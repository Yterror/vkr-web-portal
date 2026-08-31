<?php

session_start();

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Помощь</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

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

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="about">

    <div class="container">

        <div class="breadcrumbs">

            <a href="index.php">Главная</a>

            <span>→</span>

            <span>Помощь</span>

        </div>

        <h1>Помощь</h1>

        <p>
            Данный раздел содержит основные рекомендации по работе
            с Web-порталом опросов и описывает возможности системы
            для различных категорий пользователей.
        </p>

        <h2>Для студентов</h2>

        <p>
            После авторизации студент может открыть список доступных
            опросов, выбрать необходимый опрос и отправить свои ответы.
            Перед отправкой рекомендуется проверить заполненные поля
            и убедиться в правильности выбранных вариантов.
        </p>

        <h2>Для преподавателей</h2>

        <p>
            Преподаватель может создавать опросы, добавлять вопросы,
            просматривать результаты и загружать необходимые файлы.
            Для работы с результатами необходимо выбрать соответствующий
            опрос в панели преподавателя.
        </p>

        <h2>Для администратора</h2>

        <p>
            Администратор получает доступ к отдельной панели управления
            пользователями, опросами, результатами и категориями.
            Доступные действия определяются ролью пользователя
            в системе.
        </p>

        <h2>Общие рекомендации</h2>

        <ul>

            <li>
                Используйте актуальные данные при работе с системой.
            </li>

            <li>
                Проверяйте введенную информацию перед отправкой формы.
            </li>

            <li>
                Не передавайте данные учетной записи другим пользователям.
            </li>

            <li>
                При возникновении вопросов используйте раздел
                «Обратная связь».
            </li>

        </ul>

    </div>

</section>

</main>

<footer>

    © 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>