<?php
session_start();
// Таймзона
date_default_timezone_set("UTC");

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'init.php';

// Проверка аутентификации юзера
$is_auth = is_auth();
$user_id = '';
if ($is_auth) {
    $user_id = ($_SESSION['user']['id']);
}

// Массив с аватарой и именем пользователя, если он залогинен
$user_header = user_header($is_auth);
// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);

// Запрос информации о лоте из БД
// Переменная, отображающая наличие ошибки
$error_state = true;
$bets = [];
$bet_errors = '';
$hide_bet_form = false;
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
        $error_state = false;

        // Если есть информация по лоту, то запросим его ставки
        $bets = request_bets($link, $lot_id);
        $bets_owners = array_column($bets, 'owner');

        $time_left = strtotime($lot_info['datetime_finish']) - strtotime('now');

        if ($lot_info['owner'] === $user_id or $time_left <= 0 or in_array($user_id, $bets_owners)) {
            $hide_bet_form = true;
        }
    }
}

// Отправка формы добавления ставки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $is_auth) {
    // Получаем id лота из формы добавления ставки
    $lot_id = $_POST['lot_id'];
    // Получаем сумму ставки
    $cost = $_POST['cost'];
    // Получаем id юзера из сессии
    $user_id = $_SESSION['user']['id'];

    // Проверяем значение ставки из формы
    $bet_errors = validate_bet($link, $cost, $lot_id);

    // Если ошибок нет, то добавляем ставку в БД и обновляем страницу
    if ($bet_errors === '') {
        // Вызываем функцию добавления ставки в БД. При успешном добавлении переходим на страницу лота
        $result = bet_add($link, $cost, $user_id, $lot_id);
        if ($result) {
            header("Location: lot.php?id=" . $lot_id);
        }
        else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
            print $content;
            exit();
        }
    }
}

if ($error_state) {
    $page_title = 'Лот не найден';
    $content = include_template('error.php', ['error' => '404 - страница не найдена']);
}
else {
    $content = include_template('lot_page.php',
        ['categories' => $categories,
            'lot_info' => $lot_info,
            'bets' => $bets,
            'bet_errors' => $bet_errors,
            'hide_bet_form' => $hide_bet_form,
            'time_left' => $time_left,
            'is_auth' => $is_auth,
            'user_id' => $user_id]);
}

// Собираем страницу и выводим ее на экран
$layout = include_template('layout.php',
    ['content' => $content,
        'is_auth' => $is_auth,
        'categories' => $categories,
        'user_header' => $user_header,
        'title' => $page_title]);
print($layout);
