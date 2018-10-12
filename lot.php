<?php
session_start();
// Таймзона
date_default_timezone_set("Europe/Moscow");

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'data.php';
require_once 'init.php';

// Проверка аутентификации юзера
$is_auth = is_auth();
// Массив с аватарой и именем пользователя, если он залогинен
$user_header = user_header($is_auth);
// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);

// Запрос информации о лоте из БД
// Переменная, отображающая наличие ошибки
$error_state = true;
$page_title ='Лот:';
// Если id задан, то выполнится функция запроса в БД
// При несуществующем в базе id функция вернет пустой массив в переменную $lot_info
// Статус ошибки в этом случае останется true и сработает 404
if(ISSET($_GET['id'])) {
    $lot_id = $_GET['id'];
    // Функция запрашивает необходимую информацию о лоте из БД
    $lot_info = lot_info($link, $lot_id);
    if($lot_info) {
        $page_title = $page_title . ' ' . $lot_info['title'];
        $content = include_template('lot_page.php',
            ['categories' => $categories, 'lot_info' => $lot_info, 'is_auth' => $is_auth]);
        $error_state = false;
    }
}
if ($error_state) {
    $page_title = 'Лот не найден';
    $content = include_template('error.php', ['error' => '404 - страница не найдена']);
}

// Собираем страницу и выводим ее на экран
$layout = include_template('layout.php',
    ['content' => $content,
        'is_auth' => $is_auth,
        'categories' => $categories,
        'user_header' => $user_header,
        'title' => $page_title]);
print($layout);
