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

// Запрос категорий из БД
function categories() {
    $sql_categories = "SELECT id, title FROM categories ORDER BY id ASC";
    return $sql_categories;
};

// Запрос лотов из БД
function lots() {
    $sql_lots = "SELECT l.title, starting_price, current_price, picture, c.title as category, COUNT(b.id) as bets_quantity
            FROM lots l
            LEFT JOIN categories c ON c.id = category
            LEFT JOIN bets b ON l.id = b.lot WHERE datetime_finish > CURRENT_TIMESTAMP
            GROUP BY l.id
            ORDER BY datetime_start DESC LIMIT 6";
    return $sql_lots;
};