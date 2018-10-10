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
$errors = [];

$content = include_template('lot_add.php', ['categories' => $categories, 'errors' => $errors]);

// Валидация данных из формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверка заполненности обязательных полей и заполнение массива ошибок
    $required = ['title', 'description', 'starting_price', 'datetime_finish', 'bet_increment', 'category'];
    $dict = ['title' => 'Наименование', 'description' => 'Описание', 'picture' => 'Изображение',
        'starting_price' => 'Начальная цена', 'datetime_finish' => 'Дата окончания торгов',
        'bet_increment' => 'Шаг ставки', 'category' => 'Категория'];

    foreach ($required as $key) {
        if (empty($_POST['lot'][$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    // Проверяем наличие категории в списке категорий
    $cat_id_sent = $_POST['lot']['category'];

    if (!in_array($cat_id_sent, $cat_id_list)) {
        $errors['category'] = 'Выберите категорию';
    }

    // Проверка типа данных в стоимости и шаге ставки
    $required_int = ['starting_price', 'bet_increment'];
    $min_req_int = 1;
    foreach ($required_int as $val) {
        if (!filter_var($_POST['lot'][$val], FILTER_VALIDATE_INT, ["options" => ["min_range"=>$min_req_int]])) {
            $errors[$val] = 'Введите корректную сумму';
        }
    }

    // Проверка загрузки изображения и MIME типа
    if ($_FILES['picture']['name'] !== '') {
        $upload_state = true;
        $picture_type = mime_content_type($_FILES['picture']['tmp_name']);

        if ($picture_type !== "image/jpg" && $picture_type !== "image/png") {
            $errors['file'] = 'Загрузите картинку в формате JPG или PNG';
        }
    }
    else {
        $errors['file'] = 'Вы не загрузили файл';
    }
    if (count($errors)) {
        $content = include_template('lot_add.php',
            ['errors' => $errors, 'dict' => $dict, 'categories' => $categories]);
    }
}


// Загрузка данных из формы в БД. При успешном добавлении лота переадресация на его страницу
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !count($errors)) {
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

// Сборка страницы
$layout = include_template('layout.php',
    ['categories' => $categories,
     'content' => $content,
     'is_auth' => $is_auth,
     'title' => 'Добавление лота']);
print $layout;
