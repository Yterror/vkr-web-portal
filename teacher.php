<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT * FROM polls
        WHERE POLL_USER_ID = ?
        ORDER BY POLL_ID DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Панель преподавателя</title>

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
                <li><a href="about.php">О нас</a></li>

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="teacher-panel">

    <div class="container">

        <h1>Панель преподавателя</h1>

        <p class="panel-description">

            Добро пожаловать, <?= htmlspecialchars($_SESSION['user_name']) ?>!

        </p>


        <div class="teacher-grid">


            <div class="teacher-card">

                <h2>Создать опрос</h2>

                <p>
                    Создание нового опроса для студентов университета.
                </p>

                <a href="create-poll.php" class="btn">
                    Создать
                </a>

            </div>


            <?php foreach ($polls as $poll): ?>

                <div class="teacher-card">

                    <h2>
                        <?= htmlspecialchars($poll['POLL_TITLE']) ?>
                    </h2>

                    <p>
                        Статус:
                        <?= htmlspecialchars($poll['POLL_STATUS']) ?>
                    </p>

                    <p>
                        Дата окончания:
                        <?= htmlspecialchars($poll['POLL_END_DATE']) ?>
                    </p>

                    <a
                        href="results.php?id=<?= $poll['POLL_ID'] ?>"
                        class="btn"
                    >
                        Результаты
                    </a>

                </div>

            <?php endforeach; ?>


            <div class="teacher-card">

                <h2>Выход</h2>

                <p>
                    Завершить работу.
                </p>

                <a href="index.php" class="btn">
                    Выйти
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