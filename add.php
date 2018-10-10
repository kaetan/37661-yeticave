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
// Список id категорий
$cat_id_list = array_column($categories, 'id');
// Массив с ошибками валидации
$errors = [];

$content = include_template('lot_add.php', ['categories' => $categories, 'errors' => $errors]);

// Валидация данных из формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Определяем необходимые поля
    $required = ['title', 'description', 'starting_price', 'datetime_finish', 'bet_increment'];
    // Отправленный из формы id категории
    $cat_id_sent = $_POST['lot']['category'];
    // Поля, в которые необходимо ввести число
    $required_int = ['starting_price', 'bet_increment'];

    $errors = validate($errors, $cat_id_list, $required, $cat_id_sent, $required_int);
}
if (count($errors)) {
    $content = include_template('lot_add.php', ['errors' => $errors, 'categories' => $categories]);
}

// Загрузка данных из формы в БД
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !count($errors)) {
    $lot = $_POST['lot'];
    $lot['current_price'] = $lot['starting_price'];
    // По типу загруженного изображения определяем расширение будущего файла, задаем ему имя и перемещаем в папку img
    if (mime_content_type($_FILES['picture']['tmp_name']) == "image/jpeg") {
        $filename = uniqid() . '.jpg';
    }
    elseif (mime_content_type($_FILES['picture']['tmp_name']) == "image/png") {
        $filename = uniqid() . '.png';
    }
    $lot['picture'] = 'img/' . $filename;
    move_uploaded_file($_FILES['picture']['tmp_name'], 'img/' . $filename);

    // Вызываем функцию добавления лота в БД. При успешном добавлении переходим на страницу лота
    $result = lot_add($lot, $link);
    if ($result) {
        $lot_id = mysqli_insert_id($link);

        header("Location: lot.php?id=" . $lot_id);
    } else {
        $content = include_template('error.php', ['error' => mysqli_error($link)]);
    }
}

// Сборка страницы
$layout = include_template('layout.php',
    ['categories' => $categories,
     'content' => $content,
     'is_auth' => $is_auth,
     'title' => 'Добавление лота']);
print $layout;
