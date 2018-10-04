<?php
// Имя и аватар пользователя
$user_name = 'Ivan Ivanov'; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

// товары пользователей
/*$wares = [
    [
        "name" =>"2014 Rossignol District Snowboard",
        "category" =>"Доски и лыжи",
        "cost" =>10999,
        "pic_url" =>"img/lot-1.jpg"
    ],
    [
        "name" =>"DC Ply Mens 2016/2017 Snowboard",
        "category" =>"Доски и лыжи",
        "cost" =>159999,
        "pic_url" =>"img/lot-2.jpg"
    ],
    [
        "name" =>"Крепления Union Contact Pro 2015 года размер L/XL",
        "category" =>"Крепления",
        "cost" =>8000,
        "pic_url" =>"img/lot-3.jpg"
    ],
    [
        "name" =>"Ботинки для сноуборда DC Mutiny Charocal",
        "category" =>"Ботинки",
        "cost" =>10999,
        "pic_url" =>"img/lot-4.jpg"
    ],
    [
        "name" =>"Куртка для сноуборда DC Mutiny Charocal",
        "category" =>"Одежда",
        "cost" =>7500,
        "pic_url" =>"img/lot-5.jpg"
    ],
    [
        "name" =>"Маска Oakley Canopy",
        "category" =>"Разное",
        "cost" =>5400,
        "pic_url" =>"img/lot-6.jpg"
    ]
];

// категории товаров
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
*/