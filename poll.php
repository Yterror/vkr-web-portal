<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 3) {
    header('Location: login.php');
    exit;
}

$poll_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $answers = $_POST['answers'] ?? [];

    foreach ($answers as $answer_id) {

        $sql = "INSERT INTO user_answers
                (ANS_USER_ID, ANS_OPT_ID)
                VALUES (?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_SESSION['user_id'],
            $answer_id
        ]);
    }

    $sql = "INSERT INTO poll_participants
            (PART_USER_ID, PART_POLL_ID, PART_STATUS)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_SESSION['user_id'],
        $poll_id,
        'Завершен'
    ]);

    header('Location: thank-you-poll.php');
    exit;
}

$sql = "SELECT * FROM polls
        WHERE POLL_ID = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$poll_id]);

$poll = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$poll) {
    die('Опрос не найден.');
}

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

    <title><?= htmlspecialchars($poll['POLL_TITLE']) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.googleapis.com"
          crossorigin>

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
                    <a href="index.php">
                        Главная
                    </a>
                </li>

                <li>
                    <a href="polls.php">
                        Опросы
                    </a>
                </li>

                <li>
                    <a href="about.php">
                        О нас
                    </a>
                </li>

            </ul>

        </nav>

    </div>

</header>

<main>

<section class="poll-page">

    <div class="container">

        <div class="breadcrumbs">

            <a href="index.php">
                Главная
            </a>

            <span>→</span>

            <a href="profile.php">
                Личный кабинет
            </a>

            <span>→</span>

            <a href="polls.php">
                Опросы
            </a>

            <span>→</span>

            <span>
                <?= htmlspecialchars($poll['POLL_TITLE']) ?>
            </span>

        </div>

        <div class="poll-box">

            <h1>
                <?= htmlspecialchars($poll['POLL_TITLE']) ?>
            </h1>

            <p class="poll-description">
                <?= htmlspecialchars($poll['POLL_DESCRIPTION']) ?>
            </p>

            <form method="POST">

                <?php foreach ($questions as $question): ?>

                    <div class="question">

                        <h3>
                            <?= htmlspecialchars($question['QST_ORDER']) ?>.
                            <?= htmlspecialchars($question['QST_TEXT']) ?>
                        </h3>

                        <?php if ($question['QST_TYPE'] == 'Текстовый ответ'): ?>

                            <textarea
                                name="answers[]"
                                placeholder="Введите ваш ответ"
                            ></textarea>

                        <?php else: ?>

                            <?php

                            $sql = "SELECT * FROM answer_options
                                    WHERE OPT_QST_ID = ?";

                            $stmt = $pdo->prepare($sql);

                            $stmt->execute([
                                $question['QST_ID']
                            ]);

                            $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            ?>

                            <?php foreach ($answers as $answer): ?>

                                <label>

                                    <input
                                        type="<?= $question['QST_TYPE'] == 'Несколько вариантов ответа' ? 'checkbox' : 'radio' ?>"
                                        name="answers[]"
                                        value="<?= $answer['OPT_ID'] ?>"
                                    >

                                    <?= htmlspecialchars($answer['OPT_TEXT']) ?>

                                </label>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

                <button type="submit" class="btn">
                    Отправить ответы
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