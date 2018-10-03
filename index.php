<?php
// Таймзона
date_default_timezone_set("Europe/Moscow");

// Рандомайзер залогинен/не залогинен
$is_auth = rand(0, 1);

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'data.php';
require_once 'init.php';

// Вывод ошибки при неудачном подключении к БД
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
    $layout = include_template('layout.php',
        ['content' => $content, 'is_auth' => $is_auth, 'categories' =>[], 'title' => 'Главная']);
    print($layout);
    exit();
}

// Показ категорий из БД
$sql_categories = "SELECT id, title FROM categories ORDER BY id ASC";
$result = mysqli_query($link, $sql_categories);
if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
}

// Показ лотов из БД
$sql_lots = "SELECT l.title, starting_price, current_price, picture, c.title as category, COUNT(b.id) as bets_quantity
            FROM lots l
            LEFT JOIN categories c ON c.id = category
            LEFT JOIN bets b ON l.id = b.lot WHERE datetime_finish > CURRENT_TIMESTAMP
            GROUP BY l.id
            ORDER BY datetime_start DESC LIMIT 6";
if ($res = mysqli_query($link, $sql_lots)) {
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $content = include_template('main.php', ['lots' => $lots, 'categories' => $categories]);
} else {
    $content = include_template('error.php', ['error' => mysqli_error($link)]);
}

// Собираем страницу и выводим ее на экран
$layout = include_template('layout.php',
    ['content' => $content, 'is_auth' => $is_auth, 'categories' => $categories, 'title' => 'Главная']);
print($layout);