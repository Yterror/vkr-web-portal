<?php

$host = "sql111.infinityfree.com";
$dbname = "if0_42624008_webportal";
$username = "if0_42624008";
$password = "240210Kiv";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Ошибка подключения к базе данных.");

}