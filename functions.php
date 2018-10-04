<?php
// Функция-шаблонизатор
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require($name);

    $result = ob_get_clean();

    return $result;
};

// Функция форматирования цены. Добавляет пробел между каждыми тремя знаками и добавляет символ рубля
function format_cost($cost) {
    $cost = ceil($cost);
    $cost = number_format($cost, 0, ',', ' ');
    $cost = $cost . "<b class=\"rub\">р</b>";
    return($cost);
};

// Функция-таймер для лотов. Считает, сколько часов и минут осталось до полуночи
function lot_timer() {
    $seconds = strtotime('tomorrow') - strtotime('now');
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    if ($minutes < 10) {
        $minutes = '0'.$minutes;
    };
    $lot_time = $hours.":".$minutes;
    return $lot_time;
};

// Вывод ошибки при неудачном подключении к БД
function db_connection_error($link) {
    if (!$link) {
        $error = mysqli_connect_error();
        $content = include_template('error.php', ['error' => $error]);
        $layout = include_template('layout.php', ['content' => $content]);
        print($layout);
        exit();
    }
};

// Вывод ошибки запроса из БД
function bd_error($link) {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
    $layout = include_template('layout.php', ['content' => $content]);
    return $layout;
};

// Запрос категорий из БД
function categories($link) {
    $sql_categories = $sql_categories = "SELECT id, title FROM categories ORDER BY id ASC";
    $result = mysqli_query($link, $sql_categories);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        print(bd_error($link));
        exit();
    }
    return $categories;
};

// Запрос лотов из БД
function lots($link) {
    $sql_lots = $sql_lots = "SELECT l.title, starting_price, current_price, picture, c.title as category, COUNT(b.id) as bets_quantity
            FROM lots l
            LEFT JOIN categories c ON c.id = category
            LEFT JOIN bets b ON l.id = b.lot WHERE datetime_finish > CURRENT_TIMESTAMP
            GROUP BY l.id
            ORDER BY datetime_start DESC LIMIT 6";
    if ($result = mysqli_query($link, $sql_lots)) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        print(bd_error($link));
        exit();
    }
    return $lots;
};