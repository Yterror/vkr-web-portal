<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['edit_user'])) {

        $sql = "UPDATE users
                SET USER_FULL_NAME = ?,
                    USER_EMAIL = ?,
                    USER_ROLE_ID = ?
                WHERE USER_ID = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['user_full_name'],
            $_POST['user_email'],
            $_POST['user_role_id'],
            $_POST['user_id']
        ]);
    }

    if (isset($_POST['delete_user'])) {

        $sql = "DELETE FROM users
                WHERE USER_ID = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['user_id']
        ]);
    }

    header('Location: admin-users.php');
    exit;
}

$sql = "SELECT USER_ID, USER_FULL_NAME, USER_EMAIL, USER_ROLE_ID
        FROM users
        ORDER BY USER_ID";

$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Пользователи</title>

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

            <span>Пользователи</span>

        </div>

        <h1>Пользователи</h1>

        <?php foreach ($users as $user): ?>

            <div class="teacher-card">

                <p>
                    <strong>ID:</strong>
                    <?= $user['USER_ID'] ?>
                </p>

                <form method="post">

                    <input type="hidden"
                           name="user_id"
                           value="<?= $user['USER_ID'] ?>">

                    <label>
                        ФИО:
                    </label>

                    <input type="text"
                           name="user_full_name"
                           value="<?= htmlspecialchars($user['USER_FULL_NAME']) ?>"
                           required>

                    <label>
                        Email:
                    </label>

                    <input type="email"
                           name="user_email"
                           value="<?= htmlspecialchars($user['USER_EMAIL']) ?>"
                           required>

                    <label>
                        Роль:
                    </label>

                    <select name="user_role_id">

                        <option value="1"
                            <?= $user['USER_ROLE_ID'] == 1 ? 'selected' : '' ?>>
                            Администратор
                        </option>

                        <option value="2"
                            <?= $user['USER_ROLE_ID'] == 2 ? 'selected' : '' ?>>
                            Преподаватель
                        </option>

                        <option value="3"
                            <?= $user['USER_ROLE_ID'] == 3 ? 'selected' : '' ?>>
                            Студент
                        </option>

                    </select>

                    <br><br>

                    <button type="submit"
                            name="edit_user"
                            class="btn">
                        Сохранить изменения
                    </button>

                    <button type="submit"
                            name="delete_user"
                            class="btn"
                            onclick="return confirm('Удалить этого пользователя?');">
                        Удалить
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