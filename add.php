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

$content = include_template('lot_add.php', ['categories' => $categories]);

// Валидация данных из формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['title', 'description', 'picture', 'starting_price', 'datetime_finish', 'bet_increment', 'category'];
    $dict = ['title' => 'Наименование', 'description' => 'Описание', 'picture' => 'Изображение',
        'starting_price' => 'Начальная цена', 'datetime_finish' => 'Дата окончания торгов',
        'bet_increment' => 'Шаг ставки', 'category' => 'Категория'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    var_dump($errors);
    exit();

    if ($_FILES['picture']['name'] !== '') {
        $picture_type = mime_content_type($_FILES['picture']['tmp_name']);

        if ($picture_type !== "image/jpg" && $picture_type !== "image/png") {
            $errors['file'] = 'Загрузите картинку в формате JPG или PNG';
            print 'Загрузите картинку в формате JPG или PNG';
        }
    }
    else {
        $errors['file'] = 'Вы не загрузили файл';
        print 'Вы не загрузили файл';
    }
}
/*
// Загрузка данных из формы в БД
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST['lot'];
    $lot['current_price'] = $lot['starting_price'];
    $filename = uniqid() . '.jpg';
    $lot['picture'] = 'img/' . $filename;
    move_uploaded_file($_FILES['picture']['tmp_name'], 'img/' . $filename);

    $sql = "INSERT INTO lots
            (datetime_start, title, description, picture, starting_price, current_price,
            datetime_finish, bet_increment, category, owner)
            VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, 1)";
    $stmt = db_get_prepare_stmt($link, $sql, [$lot['title'], $lot['description'], $lot['picture'],
        $lot['starting_price'], $lot['current_price'], $lot['datetime_finish'], $lot['bet_increment'], $lot['category']]);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $lot_id = mysqli_insert_id($link);

        header("Location: lot.php?id=" . $lot_id);
    } else {
        $content = include_template('error.php', ['error' => mysqli_error($link)]);
    }
}
*/

$layout = include_template('layout.php',
    ['categories' => $categories,
     'content' => $content,
     'is_auth' => $is_auth,
     'title' => 'Добавление лота']);
print $layout;
