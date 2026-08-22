<?php

session_start();

require_once __DIR__ . '/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $text = trim($_POST['message']);

    if ($name != '' && $email != '' && $subject != '' && $text != '') {

        $sql = "INSERT INTO feedback
                (FEEDBACK_NAME, FEEDBACK_EMAIL, FEEDBACK_SUBJECT, FEEDBACK_MESSAGE)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $name,
            $email,
            $subject,
            $text
        ]);

        $message = 'Сообщение успешно отправлено.';

    } else {

        $message = 'Заполните все поля.';

    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Обратная связь</title>

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

                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 3): ?>

                    <li><a href="profile.php">Личный кабинет</a></li>

                <?php endif; ?>

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="create-poll-page">

    <div class="container">

        <div class="feedback-box">

            <h1>Обратная связь</h1>

            <?php if ($message != ''): ?>

                <p style="text-align:center; margin-bottom:20px;">
                    <?= htmlspecialchars($message) ?>
                </p>

            <?php endif; ?>

            <form method="POST">

                <label>Имя</label>

                <input
                    type="text"
                    name="name"
                    required
                >

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    required
                >

                <label>Тема</label>

                <input
                    type="text"
                    name="subject"
                    required
                >

                <label>Сообщение</label>

                <textarea
                    name="message"
                    required
                ></textarea>

                <button type="submit" class="btn">
                    Отправить
                </button>

            </form>

        </div>

    </div>

</section>

</main>

<footer>

© 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>