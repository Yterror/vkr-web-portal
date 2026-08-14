<?php

require_once __DIR__ . '/db.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if ($fullName === '' || $email === '' || $password === '') {

        $message = 'Пожалуйста, заполните все обязательные поля.';
        $messageType = 'error';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = 'Введите корректный адрес электронной почты.';
        $messageType = 'error';

    } elseif ($password !== $passwordConfirm) {

        $message = 'Пароли не совпадают.';
        $messageType = 'error';

    } elseif (strlen($password) < 4) {

        $message = 'Пароль должен содержать не менее 4 символов.';
        $messageType = 'error';

    } else {

        try {

            /*
             Проверяем, существует ли пользователь
             с таким email.
             */

            $check = $pdo->prepare(
                "SELECT USER_ID 
                 FROM users 
                 WHERE USER_EMAIL = ?"
            );

            $check->execute([$email]);

            if ($check->fetch()) {

                $message = 'Пользователь с таким email уже зарегистрирован.';
                $messageType = 'error';

            } else {

                /*
                 Получаем роль "Студент"
                 По умолчанию новый пользователь
                 регистрируется как студент.
                 */

                $role = $pdo->prepare(
                    "SELECT ROLE_ID 
                     FROM roles 
                     WHERE ROLE_NAME = 'Студент'
                     LIMIT 1"
                );

                $role->execute();

                $roleData = $role->fetch();

                if (!$roleData) {

                    $message = 'Ошибка: роль "Студент" не найдена.';
                    $messageType = 'error';

                } else {


                    $passwordHash = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    /*Добавляем пользователя.*/

                    $insert = $pdo->prepare(
                        "INSERT INTO users
                        (
                            USER_ROLE_ID,
                            USER_FULL_NAME,
                            USER_EMAIL,
                            USER_PASSWORD
                        )
                        VALUES (?, ?, ?, ?)"
                    );

                    $insert->execute([
                        $roleData['ROLE_ID'],
                        $fullName,
                        $email,
                        $passwordHash
                    ]);

                    $message = 'Регистрация успешно завершена!';
                    $messageType = 'success';
                }
            }

        } catch (PDOException $e) {

            $message = 'Произошла ошибка при регистрации.';
            $messageType = 'error';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Регистрация</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

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

                <li>
                    <a href="polls.php">Опросы</a>
                </li>

                <li>
                    <a href="about.php">О нас</a>
                </li>

            </ul>

        </nav>

    </div>

</header>


<main>

    <div class="login-box">

        <h2>Регистрация</h2>

        <?php if ($message !== ''): ?>

            <div class="register-message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <?php if ($messageType !== 'success'): ?>

            <form method="POST">

                <label for="full_name">
                    ФИО
                </label>

                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    placeholder="Введите ФИО"
                    required
                >


                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Введите email"
                    required
                >


                <label for="password">
                    Пароль
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Введите пароль"
                    required
                >


                <label for="password_confirm">
                    Повторите пароль
                </label>

                <input
                    type="password"
                    id="password_confirm"
                    name="password_confirm"
                    placeholder="Повторите пароль"
                    required
                >


                <button
                    class="btn"
                    type="submit"
                >
                    Зарегистрироваться
                </button>

            </form>

        <?php else: ?>

            <a
                href="login.php"
                class="btn"
            >
                Перейти ко входу
            </a>

        <?php endif; ?>

    </div>

</main>


<footer>

    © 2026 Московский университет им. С.Ю. Витте

</footer>

</body>

</html>