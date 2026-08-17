<?php

session_start();

require_once __DIR__ . '/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE USER_EMAIL = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['USER_PASSWORD'])) {

        $_SESSION['user_id'] = $user['USER_ID'];
        $_SESSION['user_name'] = $user['USER_FULL_NAME'];
        $_SESSION['user_role'] = $user['USER_ROLE_ID'];

        if ($user['USER_ROLE_ID'] == 1) {
            header('Location: admin.php');
        } elseif ($user['USER_ROLE_ID'] == 2) {
            header('Location: teacher.php');
        } else {
            header('Location: polls.php');
}

exit;

    } else {

        $message = 'Неверный email или пароль.';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Вход в систему</title>

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

    <div class="login-box">

        <h2>Вход в систему</h2>

        <?php if ($message !== ''): ?>

            <p style="text-align:center; margin-bottom:20px;">
                <?= htmlspecialchars($message) ?>
            </p>

        <?php endif; ?>

        <form method="POST">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Введите email"
                required
            >

            <label>Пароль</label>

            <input
                type="password"
                name="password"
                placeholder="Введите пароль"
                required
            >

            <button class="btn" type="submit">
                Войти
            </button>
            
            <a href="register.php" class="btn">
                Регистрация
            </a>

        </form>

    </div>

</main>

<footer>

    © 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>