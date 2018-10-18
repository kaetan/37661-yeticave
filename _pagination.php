<?php
// Считаем, сколько всего лотов нашлось
$total_items = count(lots($link, $is_search, $search_param, $is_category, $verified_category_id, '', ''));

// Текущая страница. Если не задана, то будет 1
$current_page = $_GET['page'] ?? 1;
// Максимальное количество лотов на странице
$page_items = 9;
//Количество страниц
$pages_count = ceil($total_items / $page_items);
// Оффсет для каждой страницы
$offset = ($current_page - 1) * $page_items;
// Массив с номерами страниц
$pages = range(1, $pages_count);

// Запрашиваем лоты по указанной категории
$lots = lots($link, $is_search, $search_param, $is_category, $verified_category_id, $page_items, $offset);
