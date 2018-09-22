<?php
// Рандомайзер залогинен/не залогинен
$is_auth = rand(0, 1);

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'data.php';

// Собираем страницу и выводим ее на экран
$page_content = include_template('index.php', ['wares' => $wares, 'categories' => $categories]);
$layout_content = include_template('layout.php',
    ['page_content' => $page_content, 'is_auth' => $is_auth, 'categories' => $categories, 'title' => 'Главная']);
print($layout_content);