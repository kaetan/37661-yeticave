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

// Запрос лотов из БД
$lots = lots($link);

// Собираем страницу и выводим ее на экран
$content = include_template('main.php', ['lots' => $lots, 'categories' => $categories]);
$layout = include_template('layout.php',
    ['content' => $content, 'is_auth' => $is_auth, 'categories' => $categories, 'title' => 'Главная']);
print($layout);