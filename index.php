<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Web-портал опросов</title>

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

        <li><a href="index.php">Главная</a>
        <li><a href="news.php">Новости</a></li>
        <li><a href="about.php">О нас</a></li>
        <li><a href="rules.php">Правила</a></li>
        <li><a href="contacts.php">Контакты</a></li>
        <li><a href="privacy.php">Конфиденциальность</a></li>
        <li><a href="faq.php">FAQ</a></li>
        <li><a href="help.php">Помощь</a></li>
        <li><a href="feedback.php">Обратная связь</a></li>
        <li><a href="register.php">Регистрация</a></li>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 3): ?>

            <li><a href="profile.php">Личный кабинет</a></li>

        <?php endif; ?>
        
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 2): ?>
        
            <li><a href="teacher.php">Панель преподавателя</a></li>
        
        <?php endif; ?>

    </ul>

</nav>
        
    </div>

</header>

<main>

<section class="hero">

    <div class="container">

        <h1>

            Информационно-аналитический<br>

            Web-портал

        </h1>

        <p>

            для проведения опросов, голосований и сбора обратной связи<br>

            Московского университета имени С.Ю. Витте

        </p>

        <a href="login.php" class="btn">Войти в систему</a>


    </div>

</section>

</main>

<footer>

    © 2026 Московский университет им. С.Ю. Витте

</footer>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>

</html>