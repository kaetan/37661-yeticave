<?php
session_start();
// Таймзона
date_default_timezone_set("UTC");

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'init.php';

// Проверка аутентификации юзера
$is_auth = is_auth();
// Если не залогинен, то здесь делать нечего
if (!$is_auth) {
    header("Location: index.php");
    exit();
}
// Массив с аватарой и именем пользователя, если он залогинен
$user_header = user_header($is_auth);
// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);
$bets = [];

// Получаем идентификатор юзера
$user_id = ($_SESSION['user']['id']);

$bets = bets($link, $user_id);

// Собираем страницу и выводим ее на экран
$content = include_template('my_lots.php', ['bets' => $bets, 'user_id' => $user_id, 'categories' => $categories]);

$layout = include_template('layout.php',
    ['content' => $content,
        'is_auth' => $is_auth,
        'user_header' => $user_header,
        'categories' => $categories,
        'title' => 'Главная']);
print($layout);