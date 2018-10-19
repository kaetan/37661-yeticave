<?php
session_start();
// Таймзона
date_default_timezone_set("UTC");

// Подключаем нужные файлы
require_once 'functions.php';
require_once 'init.php';

// Проверка аутентификации юзера
$is_auth = is_auth();
// Массив с аватарой и именем пользователя, если он залогинен
$user_header = user_header($is_auth);
// Проверка подключения к БД и вывод ошибки, если она имеется
db_connection_error($link);

// Запрос категорий из БД
$categories = categories($link);

// Пустой массив для лотов
$lots = [];
// Переменная для "ничего не найдено"
$not_found = true;
// Переменная для пустой пагинации
$pagination = '';
// Переменная для пустого поиска
$search_unsafe = '';
// Переменная для некорректного номера страницы
$bad_page = false;


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    // Данные из строки поиска записываем в переменную
    $search_unsafe = trim($_GET['q']) ?? '';
    $search = mysqli_real_escape_string($link, $search_unsafe) ;

    if ($search) {
        // Считаем, сколько всего лотов нашлось
        $total_items = count(lots($link, $search));

        // Максимальное количество лотов на странице
        $page_items = 9;
        //Количество страниц. Convert to int
        $pages_count = ceil($total_items / $page_items);
        $pages_count = intval($pages_count);
        // Массив с номерами страниц
        $pages = range(1, $pages_count);


        // Текущая страница. Если не задана, то будет 1
        $current_page = !empty($_GET['page']) ? $_GET['page'] : '1';
        // Проверяем наличие номера текущей страницы
        if (!filter_var($current_page, FILTER_VALIDATE_INT, ["options" => ["min_range"=>1, "max_range"=>$pages_count]])) {
            $bad_page = true;
        }
        else {
            // Конвертируем значение текущей страницы в число
            $current_page = intval($current_page);
            // Оффсет для каждой страницы
            $offset = ($current_page - 1) * $page_items;

            // Запрашиваем лоты по указанному поисковому запросу
            $lots = lots($link, $search, '', $page_items, $offset);

            // Устанавливаем текст ссылок для пагинатора
            $page_link = 'search.php?q='.$search.'&';

            if ($lots !== []) {
                $not_found = false;
            }
            $pagination = include_template('_pagination.php',
                ['pages_count' => $pages_count,
                    'page_link' => $page_link,
                    'current_page' => $current_page,
                    'pages' => $pages]);
        }

    }
}

// Собираем страницу и выводим ее на экран

$content = include_template('search.php',
    ['not_found' => $not_found,
        'bad_page' => $bad_page,
        'pagination' => $pagination,
        'search_unsafe' => $search_unsafe,
        'lots' => $lots,
        'categories' => $categories]);

$layout = include_template('layout.php',
    ['content' => $content,
        'is_auth' => $is_auth,
        'user_header' => $user_header,
        'categories' => $categories,
        'title' => 'Результаты поиска']);
print($layout);