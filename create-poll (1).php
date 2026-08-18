<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['poll_title']);
    $description = trim($_POST['poll_description']);
    $category = $_POST['poll_category'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $question1 = trim($_POST['question1']);
    $question1_type = $_POST['question1_type'];

    $question2 = trim($_POST['question2']);
    $question2_type = $_POST['question2_type'];

    $question3 = trim($_POST['question3']);
    $question3_type = $_POST['question3_type'];

    if (
        $title != '' &&
        $category != '' &&
        $start_date != '' &&
        $end_date != '' &&
        $question1 != '' &&
        $question2 != '' &&
        $question3 != ''
    ) {

        $sql = "INSERT INTO polls
                (POLL_TITLE, POLL_DESCRIPTION, POLL_START_DATE,
                 POLL_END_DATE, POLL_STATUS, POLL_CAT_ID, POLL_USER_ID)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $title,
            $description,
            $start_date,
            $end_date,
            'Активен',
            $category,
            $_SESSION['user_id']
        ]);

        $poll_id = $pdo->lastInsertId();


        $sql = "INSERT INTO questions
                (QST_POLL_ID, QST_TEXT, QST_TYPE, QST_ORDER)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $poll_id,
            $question1,
            $question1_type,
            1
        ]);

        $question1_id = $pdo->lastInsertId();


        foreach ($_POST['question1_answers'] as $answer) {

            $answer = trim($answer);

            if ($answer != '') {

                $sql = "INSERT INTO answer_options
                        (OPT_QST_ID, OPT_TEXT)
                        VALUES (?, ?)";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    $question1_id,
                    $answer
                ]);
            }
        }


        $sql = "INSERT INTO questions
                (QST_POLL_ID, QST_TEXT, QST_TYPE, QST_ORDER)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $poll_id,
            $question2,
            $question2_type,
            2
        ]);

        $question2_id = $pdo->lastInsertId();


        foreach ($_POST['question2_answers'] as $answer) {

            $answer = trim($answer);

            if ($answer != '') {

                $sql = "INSERT INTO answer_options
                        (OPT_QST_ID, OPT_TEXT)
                        VALUES (?, ?)";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    $question2_id,
                    $answer
                ]);
            }
        }


        $sql = "INSERT INTO questions
                (QST_POLL_ID, QST_TEXT, QST_TYPE, QST_ORDER)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $poll_id,
            $question3,
            $question3_type,
            3
        ]);


        $message = 'Опрос успешно создан.';

    } else {

        $message = 'Заполните все обязательные поля.';
    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Создание опроса</title>

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

<section class="create-poll-page">

    <div class="container">

        <div class="create-poll-box">

            <div class="create-poll-header">

                <h1>Создание нового опроса</h1>

                <p>
                    Заполните основные сведения и добавьте вопросы
                    для проведения опроса.
                </p>

            </div>


            <?php if ($message != ''): ?>

                <p style="text-align:center; margin-bottom:20px;">
                    <?= htmlspecialchars($message) ?>
                </p>

            <?php endif; ?>


            <form method="POST">


                <div class="form-section">

                    <h2>Основная информация</h2>


                    <label for="poll-title">
                        Название опроса
                    </label>

                    <input
                        type="text"
                        id="poll-title"
                        name="poll_title"
                        placeholder="Например: Оценка качества образовательного процесса"
                        required
                    >


                    <label for="poll-description">
                        Описание
                    </label>

                    <textarea
                        id="poll-description"
                        name="poll_description"
                        placeholder="Введите описание опроса"
                    ></textarea>


                    <label for="poll-category">
                        Категория
                    </label>

                    <select
                        id="poll-category"
                        name="poll_category"
                        required
                    >

                        <option value="">
                            Выберите категорию
                        </option>

                        <option value="1">
                            Учебный процесс
                        </option>

                        <option value="2">
                            Электронные сервисы
                        </option>

                        <option value="3">
                            Студенческая жизнь
                        </option>

                        <option value="4">
                            Обратная связь
                        </option>

                    </select>

                </div>


                <div class="form-section">

                    <h2>Срок проведения</h2>


                    <div class="date-fields">

                        <div>

                            <label for="start-date">
                                Дата начала
                            </label>

                            <input
                                type="date"
                                id="start-date"
                                name="start_date"
                                required
                            >

                        </div>


                        <div>

                            <label for="end-date">
                                Дата окончания
                            </label>

                            <input
                                type="date"
                                id="end-date"
                                name="end_date"
                                required
                            >

                        </div>

                    </div>

                </div>


                <div class="form-section">

                    <h2>Вопрос 1</h2>


                    <label for="question1">
                        Текст вопроса
                    </label>

                    <input
                        type="text"
                        id="question1"
                        name="question1"
                        placeholder="Введите текст вопроса"
                        required
                    >


                    <label>
                        Тип вопроса
                    </label>

                    <select name="question1_type">

                        <option value="Один вариант ответа">
                            Один вариант ответа
                        </option>

                        <option value="Несколько вариантов ответа">
                            Несколько вариантов ответа
                        </option>

                        <option value="Текстовый ответ">
                            Текстовый ответ
                        </option>

                    </select>


                    <label>
                        Варианты ответа
                    </label>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question1_answers[]"
                            placeholder="Вариант ответа 1"
                        >

                    </div>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question1_answers[]"
                            placeholder="Вариант ответа 2"
                        >

                    </div>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question1_answers[]"
                            placeholder="Вариант ответа 3"
                        >

                    </div>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question1_answers[]"
                            placeholder="Вариант ответа 4"
                        >

                    </div>

                </div>


                <div class="form-section">

                    <h2>Вопрос 2</h2>


                    <label for="question2">
                        Текст вопроса
                    </label>

                    <input
                        type="text"
                        id="question2"
                        name="question2"
                        placeholder="Введите текст вопроса"
                        required
                    >


                    <label>
                        Тип вопроса
                    </label>

                    <select name="question2_type">

                        <option value="Один вариант ответа">
                            Один вариант ответа
                        </option>

                        <option value="Несколько вариантов ответа">
                            Несколько вариантов ответа
                        </option>

                        <option value="Текстовый ответ">
                            Текстовый ответ
                        </option>

                    </select>


                    <label>
                        Варианты ответа
                    </label>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question2_answers[]"
                            placeholder="Вариант ответа 1"
                        >

                    </div>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question2_answers[]"
                            placeholder="Вариант ответа 2"
                        >

                    </div>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question2_answers[]"
                            placeholder="Вариант ответа 3"
                        >

                    </div>


                    <div class="answer-input">

                        <input
                            type="text"
                            name="question2_answers[]"
                            placeholder="Вариант ответа 4"
                        >

                    </div>

                </div>


                <div class="form-section">

                    <h2>Вопрос 3</h2>


                    <label for="question3">
                        Текст вопроса
                    </label>

                    <input
                        type="text"
                        id="question3"
                        name="question3"
                        placeholder="Введите текст вопроса"
                        required
                    >


                    <label>
                        Тип вопроса
                    </label>

                    <select name="question3_type">

                        <option value="Текстовый ответ">
                            Текстовый ответ
                        </option>

                        <option value="Один вариант ответа">
                            Один вариант ответа
                        </option>

                        <option value="Несколько вариантов ответа">
                            Несколько вариантов ответа
                        </option>

                    </select>

                </div>


                <div class="create-poll-actions">

                    <a
                        href="teacher.php"
                        class="btn btn-cancel"
                    >
                        Отмена
                    </a>


                    <button
                        type="submit"
                        class="btn"
                    >
                        Создать опрос
                    </button>

                </div>

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