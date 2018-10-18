<?php
session_start();
// Таймзона
date_default_timezone_set("UTC");

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'init.php';

// Проверка аутентификации юзера
$is_auth = is_auth();
// Массив с аватарой и именем пользователя, если он залогинен
$user_header = user_header($is_auth);
// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);

$lots = [];
$not_found = true;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Данные из строки поиска записываем в переменную
    $search_unsafe = trim($_GET['q']);
    $search = mysqli_real_escape_string($link, $search_unsafe) ?? '';

    if ($search) {
        $lots = lots($link, 1, $search, 0, '');
        if ($lots) {
            $not_found = false;
        }
    }
}

// Собираем страницу и выводим ее на экран
$content = include_template('search.php',
    ['not_found' => $not_found,
        'search_unsafe' => $search_unsafe,
        'lots' => $lots,
        'categories' => $categories]);

$layout = include_template('layout.php',
    ['content' => $content,
        'is_auth' => $is_auth,
        'user_header' => $user_header,
        'categories' => $categories,
        'title' => 'Результаты поиска']);
print($layout);