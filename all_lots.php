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
// Список id категорий
$cat_id_list = array_column($categories, 'id');
// Пустое значение переданной категории
$category_title = '';
// Запрос лотов из БД
$lots = lots($link, 0, '', 0, '');

// Если передан id категории, то проверим его, и затем выведем лоты этой категории
if(isset($_GET['cat'])) {
    $category_id = mysqli_real_escape_string($link,$_GET['cat']);
    if (in_array($category_id, $cat_id_list)) {
        // Получаем идентификатор подмассива, содержащего переданный id категории
        $cat_array_id = array_search($category_id, $cat_id_list);
        // Получаем название категории из подмассива
        $category_title = $categories[$cat_array_id]['title'];
        // Запрашиваем лоты по указанной категории
        $lots = lots($link, 0, '', 1, $category_id);
    }
}

$content = include_template('all_lots.php',
    ['lots' => $lots,
        'category_title' => $category_title,
        'categories' => $categories]);
$layout = include_template('layout.php',
    ['content' => $content,
        'is_auth' => $is_auth,
        'user_header' => $user_header,
        'categories' => $categories,
        'title' => 'Главная']);
print($layout);
