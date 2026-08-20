<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 1 && $_SESSION['user_role'] != 2)) {
    header('Location: login.php');
    exit;
}

$poll_id = $_GET['id'];

$sql = "SELECT * FROM polls WHERE POLL_ID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$poll_id]);

$poll = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$poll) {
    die('Опрос не найден.');
}

$sql = "SELECT COUNT(DISTINCT PART_USER_ID)
        FROM poll_participants
        WHERE PART_POLL_ID = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$poll_id]);

$total_users = $stmt->fetchColumn();

$sql = "SELECT * FROM questions
        WHERE QST_POLL_ID = ?
        ORDER BY QST_ORDER";

$stmt = $pdo->prepare($sql);
$stmt->execute([$poll_id]);

$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Результаты опроса</title>

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

<section class="results-page">

    <div class="container">

        <div class="results-card">

            <h1>Результаты опроса</h1>

            <p>
                Опрос:
                <strong><?= htmlspecialchars($poll['POLL_TITLE']) ?></strong>
            </p>

            <p>
                Всего участников:
                <strong><?= $total_users ?></strong>
            </p>

            <hr>


            <?php foreach ($questions as $question): ?>

                <h3>
                    <?= htmlspecialchars($question['QST_ORDER']) ?>.
                    <?= htmlspecialchars($question['QST_TEXT']) ?>
                </h3>


                <?php

                $sql = "SELECT * FROM answer_options
                        WHERE OPT_QST_ID = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([$question['QST_ID']]);

                $options = $stmt->fetchAll(PDO::FETCH_ASSOC);

                ?>


                <?php foreach ($options as $option): ?>

                    <?php

                    $sql = "SELECT COUNT(DISTINCT ANS_USER_ID)
                            FROM user_answers
                            WHERE ANS_OPT_ID = ?";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$option['OPT_ID']]);

                    $count = $stmt->fetchColumn();

                    if ($total_users > 0) {
                        $percent = round(($count / $total_users) * 100);
                    } else {
                        $percent = 0;
                    }

                    ?>

                    <p>
                        <?= htmlspecialchars($option['OPT_TEXT']) ?>
                        — <?= $percent ?>%
                    </p>

                    <div class="progress">

                        <div
                            class="progress-fill"
                            style="width:<?= $percent ?>%;"
                        ></div>

                    </div>

                <?php endforeach; ?>

            <?php endforeach; ?>


            <br>

            <a href="teacher.php" class="btn">
                Вернуться к панели преподавателя
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