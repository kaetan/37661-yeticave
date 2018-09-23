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