<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['edit_category'])) {

        $sql = "UPDATE categories
                SET CAT_NAME = ?, CAT_DESCRIPTION = ?
                WHERE CAT_ID = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['cat_name'],
            $_POST['cat_description'],
            $_POST['cat_id']
        ]);
    }

    if (isset($_POST['delete_category'])) {

        $sql = "DELETE FROM categories
                WHERE CAT_ID = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['cat_id']
        ]);
    }

    header('Location: admin-categories.php');
    exit;
}

$sql = "SELECT CAT_ID, CAT_NAME, CAT_DESCRIPTION
        FROM categories
        ORDER BY CAT_ID";

$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Категории</title>

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

            <span>Категории</span>

        </div>

        <h1>Категории</h1>

        <?php foreach ($categories as $category): ?>

            <div class="teacher-card">

                <h2>
                    <?= htmlspecialchars($category['CAT_NAME']) ?>
                </h2>

                <p>
                    <?= htmlspecialchars($category['CAT_DESCRIPTION']) ?>
                </p>

                <form method="post">

                    <input type="hidden"
                           name="cat_id"
                           value="<?= $category['CAT_ID'] ?>">

                    <input type="text"
                           name="cat_name"
                           value="<?= htmlspecialchars($category['CAT_NAME']) ?>"
                           required>

                    <textarea name="cat_description"
                              required><?= htmlspecialchars($category['CAT_DESCRIPTION']) ?></textarea>

                    <button type="submit"
                            name="edit_category"
                            class="btn">
                        Сохранить изменения
                    </button>

                    <button type="submit"
                            name="delete_category"
                            class="btn"
                            onclick="return confirm('Удалить эту категорию?');">
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