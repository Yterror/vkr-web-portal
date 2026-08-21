<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT polls.POLL_TITLE,
               poll_participants.PART_STATUS
        FROM poll_participants
        JOIN polls
        ON poll_participants.PART_POLL_ID = polls.POLL_ID
        WHERE poll_participants.PART_USER_ID = ?
        ORDER BY poll_participants.PART_ID DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);

$history = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>История опросов</title>

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

        <h1>История опросов</h1>

        <?php if (count($history) > 0): ?>

            <?php foreach ($history as $item): ?>

                <div class="teacher-card">

                    <h2>
                        <?= htmlspecialchars($item['POLL_TITLE']) ?>
                    </h2>

                    <p>
                        Статус:
                        <?= htmlspecialchars($item['PART_STATUS']) ?>
                    </p>

                </div>

                <br>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="teacher-card">
                <p>Вы пока не проходили опросы.</p>
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