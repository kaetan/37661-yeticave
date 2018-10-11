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
// Массив с ошибками валидации
$errors = [];



$content = include_template('login.php', ['errors' => $errors, 'categories' => $categories]);
$layout = include_template('layout.php',
    ['categories' => $categories,
        'content' => $content,
        'is_auth' => $is_auth,
        'title' => 'Добавление лота']);
print $layout;