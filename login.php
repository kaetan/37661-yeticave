<?php
session_start();
// Таймзона
date_default_timezone_set("UTC");

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'init.php';

// Проверка аутентификации юзера
$is_auth = is_auth();
// Если залогинен, то здесь юзеру делать нечего, переадресовываем на главную
if ($is_auth) {
    header("Location: index.php");
    exit();
}
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
        // Переменная проверки пароля, по умолчанию false
        $compare = false;
        // Если юзер не найден по email, то выводим ошибку
        if (empty($user_info) ) {
            $errors['email'] = 'Вы ввели неверный email';
        }
        // Если юзер найден, сравним хэши паролей и запишем булевый результат в переменную проверки пароля
        else {
            $compare = password_verify($form['password'], $user_info['password']);
        }
        // Если пароль прошел проверку, то убираем пароль из данных о юзере и передаем их в сессию
        if ($compare) {
            unset($user_info['password']);
            $_SESSION['user'] = $user_info;
        }
        // Если пароль не прошел проверку, то выводим ошибку
        else {
            $errors['password'] = 'Вы ввели неверный пароль';
        }
    }
    // Если ошибок нет, то переводим юзера на главную
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
        'title' => 'YetiCave | Вход на сайт']);
print $layout;