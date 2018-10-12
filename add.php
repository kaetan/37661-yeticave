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
// Список id категорий
$cat_id_list = array_column($categories, 'id');
// Массив с ошибками валидации
$errors = [];

// Валидация данных из формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Вся информация о лоте, полученная из формы
    $lot = $_POST['lot'];
    // Определяем необходимые поля
    $required = ['title', 'description', 'starting_price', 'datetime_finish', 'bet_increment'];
    // Отправленный из формы id категории
    $cat_id_sent = $_POST['lot']['category'];
    // Поля, в которые необходимо ввести число
    $required_int = ['starting_price', 'bet_increment'];
    // Имя изображения, загруженного пользователем
    $picture_name = $_FILES['picture']['name'];
    // Временное имя изображения на сервере
    $picture_name_temp = $_FILES['picture']['tmp_name'];
    // Расширение изображения
    $picture_ext = pathinfo($picture_name, PATHINFO_EXTENSION);

    $errors = validate($lot, $cat_id_list, $required, $cat_id_sent, $required_int, $picture_name, $picture_name_temp);

    // При отсутствии ошибок валидации - загрузка данных из формы в БД
    if (!count($errors)) {
        $lot['current_price'] = $lot['starting_price'];

        // Задаем имя изображения и перемещаем в папку img
        $filename = uniqid() . '.' .$picture_ext;
        $lot['picture'] = 'img/' . $filename;
        move_uploaded_file($_FILES['picture']['tmp_name'], 'img/' . $filename);

        // Вызываем функцию добавления лота в БД. При успешном добавлении переходим на страницу лота
        $result = lot_add($lot, $link);
        if ($result) {
            $lot_id = mysqli_insert_id($link);

            header("Location: lot.php?id=" . $lot_id);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
            print $content;
            exit();
        }
    }
}

// Сборка страницы
if (!$is_auth) {
    $content = include_template('error.php', ['error' => 'Войдите на сайт, чтобы добавить лот', 'categories' => $categories]);
}
else {
    $content = include_template('lot_add.php', ['errors' => $errors, 'categories' => $categories]);
}
$layout = include_template('layout.php',
    ['categories' => $categories,
        'content' => $content,
        'is_auth' => $is_auth,
        'user_header' => $user_header,
        'title' => 'Добавление лота']);
print $layout;
