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
// Если залогинен, то здесь юзеру делать нечего, переадресовываем на главную
if ($is_auth) {
    header("Location: index.php");
    exit();
}
// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);
// Массив с ошибками, изначально пустой
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Информация из формы регистрации
    $form = $_POST['signup'];
    // Объявление обязательных к заполнению полей
    $required = ['username', 'password', 'contacts'];
    // Аватарка необязательна, поэтому изначально передадим в функцию пустое значение имени
    $userpic_name_temp = '';
    // Проверим наличие изображения в FILES и ...
    if (isset($_FILES['userpic'])) {
        // ... заносим в переменные имя загруженной аватарки, ее временное имя на сервере, и расширение
        $userpic_name = $_FILES['userpic']['name'];
        $userpic_name_temp = $_FILES['userpic']['tmp_name'];
        $userpic_ext = pathinfo($userpic_name, PATHINFO_EXTENSION);
    }

    // Выполняем валидацию данных из формы
    $errors = validate_signup($link, $form, $required, $userpic_name_temp);

    // При отсутсвии ошибок загружаем данные о юзере в БД
    if (!count($errors)) {

        // Поле необязательное, поэтому по дефолту будет пустым
        $form['userpic'] = '';

        // Хэшируем пароль и заносим его в переменную
        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        // Если у аватарки есть временное имя на сервере, то переименовываем и перемещаем ее
        if ($userpic_name_temp !== '') {
            $filename = uniqid() . '.' .$userpic_ext;
            $form['userpic'] = 'img/users/' . $filename;
            move_uploaded_file($_FILES['userpic']['tmp_name'], 'img/users/' . $filename);
        }
        // Добавляем пользователя в БД
        $result = user_add($link, $form, $password);
        // Если добавление успешно, то переадресация на страницу логина
        if ($result) {
            header("Location: login.php");
            exit();
        }
        else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
            print $content;
            exit();
        }
    }
}

$content = include_template('sign_up.php', ['errors' => $errors, 'categories' => $categories]);
$layout = include_template('layout.php',
    ['categories' => $categories,
        'content' => $content,
        'is_auth' => $is_auth,
        'title' => 'YetiCave | Регистрация']);
print $layout;