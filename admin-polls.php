```php
<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

$message = '';

/* Редактирование опроса */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_poll'])) {

    $poll_id = $_POST['poll_id'];
    $title = $_POST['poll_title'];
    $start_date = $_POST['poll_start_date'];
    $end_date = $_POST['poll_end_date'];
    $status = $_POST['poll_status'];

    $sql = "UPDATE polls
            SET POLL_TITLE = ?,
                POLL_START_DATE = ?,
                POLL_END_DATE = ?,
                POLL_STATUS = ?
            WHERE POLL_ID = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $title,
        $start_date,
        $end_date,
        $status,
        $poll_id
    ]);

    $message = 'Опрос успешно изменён.';
}

/* Удаление опроса */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_poll'])) {

    $poll_id = $_POST['poll_id'];

    try {

        $pdo->beginTransaction();

        /* Удаляем ответы пользователей */
        $sql = "DELETE FROM user_answers
                WHERE ANS_OPT_ID IN (
                    SELECT OPT_ID
                    FROM answer_options
                    WHERE OPT_QST_ID IN (
                        SELECT QST_ID
                        FROM questions
                        WHERE QST_POLL_ID = ?
                    )
                )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poll_id]);

        /* Удаляем варианты ответов */
        $sql = "DELETE FROM answer_options
                WHERE OPT_QST_ID IN (
                    SELECT QST_ID
                    FROM questions
                    WHERE QST_POLL_ID = ?
                )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poll_id]);

        /* Удаляем вопросы */
        $sql = "DELETE FROM questions
                WHERE QST_POLL_ID = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poll_id]);

        /* Удаляем участников опроса */
        $sql = "DELETE FROM poll_participants
                WHERE PART_POLL_ID = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poll_id]);

        /* Удаляем результаты */
        $sql = "DELETE FROM results
                WHERE RES_POLL_ID = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poll_id]);

        /* Удаляем сам опрос */
        $sql = "DELETE FROM polls
                WHERE POLL_ID = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poll_id]);

        $pdo->commit();

        $message = 'Опрос успешно удалён.';

    } catch (Exception $e) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        $message = 'Не удалось удалить опрос.';
    }
}

/* Получаем список опросов */
$sql = "SELECT POLL_ID, POLL_TITLE, POLL_STATUS, POLL_START_DATE, POLL_END_DATE
        FROM polls
        ORDER BY POLL_ID DESC";

$stmt = $pdo->query($sql);
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Опросы</title>

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

            <a href="admin.php">Панель администратора</a>

            <span>→</span>

            <span>Опросы</span>

        </div>

        <h1>Опросы</h1>

        <?php if ($message): ?>

            <p>
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <?php foreach ($polls as $poll): ?>

            <div class="teacher-card">

                <h2>
                    <?= htmlspecialchars($poll['POLL_TITLE']) ?>
                </h2>

                <!-- Форма редактирования -->
                <form method="POST">

                    <input
                        type="hidden"
                        name="poll_id"
                        value="<?= $poll['POLL_ID'] ?>"
                    >

                    <p>
                        <label>
                            Название опроса:
                        </label>
                    </p>

                    <input
                        type="text"
                        name="poll_title"
                        value="<?= htmlspecialchars($poll['POLL_TITLE']) ?>"
                        required
                    >

                    <p>
                        <label>
                            Дата начала:
                        </label>
                    </p>

                    <input
                        type="date"
                        name="poll_start_date"
                        value="<?= htmlspecialchars($poll['POLL_START_DATE']) ?>"
                        required
                    >

                    <p>
                        <label>
                            Дата окончания:
                        </label>
                    </p>

                    <input
                        type="date"
                        name="poll_end_date"
                        value="<?= htmlspecialchars($poll['POLL_END_DATE']) ?>"
                        required
                    >

                    <p>
                        <label>
                            Статус:
                        </label>
                    </p>

                    <select name="poll_status">

                        <option
                            value="Активен"
                            <?= $poll['POLL_STATUS'] == 'Активен' ? 'selected' : '' ?>
                        >
                            Активен
                        </option>

                        <option
                            value="Завершен"
                            <?= $poll['POLL_STATUS'] == 'Завершен' ? 'selected' : '' ?>
                        >
                            Завершен
                        </option>

                        <option
                            value="Черновик"
                            <?= $poll['POLL_STATUS'] == 'Черновик' ? 'selected' : '' ?>
                        >
                            Черновик
                        </option>

                    </select>

                    <br><br>

                    <button
                        type="submit"
                        name="edit_poll"
                        class="btn"
                    >
                        Сохранить изменения
                    </button>

                </form>

                <br>

                <!-- Форма удаления -->
                <form method="POST">

                    <input
                        type="hidden"
                        name="poll_id"
                        value="<?= $poll['POLL_ID'] ?>"
                    >

                    <button
                        type="submit"
                        name="delete_poll"
                        class="btn"
                        onclick="return confirm('Вы действительно хотите удалить этот опрос?');"
                    >
                        Удалить опрос
                    </button>

                </form>

            </div>

            <br>

        <?php endforeach; ?>

        <a href="admin.php" class="btn">
            Назад
        </a>

    </div>

</section>

</main>

<footer>
    © 2026 Московский университет им. С.Ю. Витте
    <br>
    Разработчик: Иван Ковалев
</footer>

</body>

</html>
```
