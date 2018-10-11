<?php
// Таймзона
date_default_timezone_set("Europe/Moscow");

// Рандомайзер залогинен/не залогинен
$is_auth = rand(0, 1);

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'data.php';
require_once 'init.php';

session_start();

// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);
// Массив с ошибками валидации
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Данные из формы
    $form = $_POST;
    // Безвредный email
    $email = mysqli_real_escape_string($link, $form['email']);

    // Валидация полей формы
    $errors = validate_login($form);

    // Если ошибок валидации нет, то запрашиваем инфу о пользователе из БД
    if (!count($errors)) {
        $user_info = get_user($link, $email);

        if (empty($user_info) ) {
            $errors['email'] = 'Пользователь с этим email не найден';
        }
        else {
            $compare = password_verify($form['password'], $user_info['password']);
            if (!$compare) {
                $errors['password'] = 'Неверный пароль';
            }
        }

    }
    var_dump($errors);
    exit();

    if (!count($errors)) {
        header("Location: index.php");
        exit();
    }
}


$content = include_template('login.php', ['errors' => $errors, 'categories' => $categories]);
$layout = include_template('layout.php',
    ['categories' => $categories,
        'content' => $content,
        'is_auth' => $is_auth,
        'title' => 'Добавление лота']);
print $layout;