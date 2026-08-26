<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT DISTINCT polls.POLL_ID, polls.POLL_TITLE,
               poll_participants.PART_STATUS
        FROM poll_participants
        JOIN polls
        ON poll_participants.PART_POLL_ID = polls.POLL_ID
        WHERE poll_participants.PART_USER_ID = ?
        ORDER BY polls.POLL_ID DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Мои результаты</title>

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

        <a href="profile.php">Личный кабинет</a>

        <span>→</span>

        <span>Мои результаты</span>

    </div>

    <h1>Мои результаты</h1>

        <?php if (count($polls) > 0): ?>

            <?php foreach ($polls as $poll): ?>

                <div class="teacher-card">

                    <h2>
                        <?= htmlspecialchars($poll['POLL_TITLE']) ?>
                    </h2>

                    <p>
                        Статус:
                        <?= htmlspecialchars($poll['PART_STATUS']) ?>
                    </p>

                    <h3>Мои ответы</h3>

                    <?php

                    $sql = "SELECT questions.QST_TEXT,
                                   answer_options.OPT_TEXT
                            FROM user_answers
                            JOIN answer_options
                            ON user_answers.ANS_OPT_ID = answer_options.OPT_ID
                            JOIN questions
                            ON answer_options.OPT_QST_ID = questions.QST_ID
                            WHERE user_answers.ANS_USER_ID = ?
                            AND questions.QST_POLL_ID = ?
                            ORDER BY questions.QST_ORDER";

                    $stmt = $pdo->prepare($sql);

                    $stmt->execute([
                        $_SESSION['user_id'],
                        $poll['POLL_ID']
                    ]);

                    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    ?>

                    <?php if (count($answers) > 0): ?>

                        <?php foreach ($answers as $answer): ?>

                            <p>
                                <strong>
                                    <?= htmlspecialchars($answer['QST_TEXT']) ?>
                                </strong>
                                <br>

                                Ваш ответ:
                                <?= htmlspecialchars($answer['OPT_TEXT']) ?>
                            </p>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <p>
                            Ответы не найдены.
                        </p>

                    <?php endif; ?>

                </div>

                <br>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="teacher-card">

                <p>
                    Вы пока не проходили опросы.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>

</main>

<footer>

© 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>