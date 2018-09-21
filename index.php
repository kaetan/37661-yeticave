<?php
// Подключаем нужные файлы
require_once 'controllers/controllers.php';
require_once 'functions.php';
require_once 'data.php';

// Собираем страницу и выводим ее на экран
$page_content = include_template('index.php', ['wares' => $wares, 'categories' => $categories]);
$layout_content = include_template('layout.php',
    ['page_content' => $page_content, 'is_auth' => $is_auth, 'categories' => $categories, 'title' => 'Главная']);
print($layout_content);