<?php
// Таймзона
date_default_timezone_set("Europe/Moscow");

// Рандомайзер залогинен/не залогинен
$is_auth = rand(0, 1);

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'data.php';
require_once 'init.php';

// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);

// Задаем пустое значение на случай если id не был передан в $_GET
// Если id пустой, либо переданный id отсутствует в БД, либо id некорректен,
// то функция lot_info вернет пустой массив $lot_info, и отработает ошибка 404
$lot_id = '';
if(ISSET($_GET['id'])) {
    $lot_id = $_GET['id'];
}
$lot_info = lot_info($link, $lot_id);
if($lot_info) {
    $content = include_template('lot_page.php',
        ['categories' => $categories, 'lot_info' => $lot_info]);
}
else {
    $content = include_template('error.php', ['error' => '404 - страница не найдена']);
}

// Собираем страницу и выводим ее на экран

$layout = include_template('layout.php',
    ['content' => $content,
     'is_auth' => $is_auth,
     'categories' => $categories,
     'title' => 'test']);
print($layout);
