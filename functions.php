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
// Функция форматирования цены. Добавляет пробел между каждыми тремя знаками
function format_cost_no_ruble($cost) {
    $cost = ceil($cost);
    $cost = number_format($cost, 0, ',', ' ');
    return($cost);
};

// Функция-таймер для лотов. Считает, сколько часов и минут осталось до окончания лота
function lot_timer($datetime_finish) {
    $seconds = strtotime($datetime_finish) - strtotime('now');
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    if ($minutes < 10) {
        $minutes = '0'.$minutes;
    };
    $lot_time = $hours.":".$minutes;
    return $lot_time;
};

// Подготовленное выражение
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}


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
function db_error($link) {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
    $layout = include_template('layout.php', ['content' => $content]);
    return $layout;
};

// Запрос категорий из БД
function categories($link) {
    $sql_categories = "SELECT id, title FROM categories ORDER BY id ASC";
    $result = mysqli_query($link, $sql_categories);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        print(db_error($link));
        exit();
    }
    return $categories;
};

// Запрос лотов из БД
function lots($link) {
    $sql_lots = "SELECT l.id, l.title, starting_price, current_price, picture, datetime_finish, c.title as category, COUNT(b.id) as bets_quantity
            FROM lots l
            LEFT JOIN categories c ON c.id = category
            LEFT JOIN bets b ON l.id = b.lot WHERE datetime_finish > CURRENT_TIMESTAMP
            GROUP BY l.id
            ORDER BY datetime_start DESC LIMIT 6";
    if ($result = mysqli_query($link, $sql_lots)) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        print(db_error($link));
        exit();
    }
    return $lots;
};

// Запрос лота по id
function lot_info($link, $lot_id) {
    $sql_lot = "SELECT l.id, l.title, picture, c.title as category, 
                      description, datetime_finish, current_price, 
                      current_price + bet_increment AS min_bet
            FROM lots l
            LEFT JOIN categories c ON c.id = category 
            WHERE l.id = $lot_id";
    if ($result = mysqli_query($link, $sql_lot)) {
        $lot_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $lot_info = [];
    }
    return $lot_info;
}