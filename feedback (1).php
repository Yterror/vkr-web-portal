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

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="css/style.css">

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

                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 3): ?>

                    <li>
                        <a href="profile.php">Личный кабинет</a>
                    </li>

                <?php endif; ?>

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="create-poll-page">

    <div class="container">

        <div class="breadcrumbs">

            <a href="index.php">Главная</a>

            <span>→</span>

            <span>Обратная связь</span>

        </div>

        <div class="feedback-box">

            <h1>Обратная связь</h1>

            <p>
                Если у вас есть вопросы, предложения или замечания
                по работе Web-портала, воспользуйтесь данной формой.
            </p>

            <?php if ($message != ''): ?>

                <p style="text-align:center; margin-bottom:20px;">
                    <?= htmlspecialchars($message) ?>
                </p>

            <?php endif; ?>

            <form method="POST">

                <label>
                    Имя
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Введите ваше имя"
                    required
                >

                <label>
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="Введите ваш email"
                    required
                >

                <label>
                    Тема сообщения
                </label>

                <input
                    type="text"
                    name="subject"
                    placeholder="Введите тему сообщения"
                    required
                >

                <label>
                    Текст сообщения
                </label>

                <textarea
                    name="message"
                    placeholder="Введите текст сообщения"
                    required
                ></textarea>

                <button
                    type="submit"
                    class="btn"
                >
                    Отправить сообщение
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