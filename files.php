<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['file'])) {

        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        $file_path = 'uploads/' . basename($file_name);

        if (move_uploaded_file($file_tmp, $file_path)) {

            $message = 'Файл успешно загружен.';

        } else {

            $message = 'Ошибка загрузки файла.';

        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Файлы</title>

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

<section class="create-poll-page">

    <div class="container">

        <div class="create-poll-box">

            <h1>Файлы</h1>

            <?php if ($message != ''): ?>

                <p style="text-align:center; margin-bottom:20px;">
                    <?= htmlspecialchars($message) ?>
                </p>

            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

                <label>
                    Выберите файл
                </label>

                <input
                    type="file"
                    name="file"
                    required
                >

                <button type="submit" class="btn">
                    Загрузить файл
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