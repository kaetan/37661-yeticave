INSERT INTO categories(cat_id, cat_title)
VALUES
(1, 'Доски и лыжи'),
(2, 'Крепления'),
(3, 'Ботинки'),
(4, 'Одежда'),
(5, 'Инструменты'),
(6, 'Разное');

INSERT INTO users(user_id, registration_date, email, username, password, user_pic, contacts, created_lots, placed_bets)
VALUES
(1, '2018-09-25 10:10:10', 'vovka_kuchkin@qmail.ru', 'Виктор Палыч', 'qwerty', NULL, 'телефон 123456', NULL, NULL),
(2, '2018-08-17 05:41:21', 'alex999@qmail.ru', 'A L E X', 'asdfgh', NULL, 'skype alexandr223334s', NULL, NULL);

INSERT INTO lots(datetime_start, lot_title, description, lot_picture, starting_price, current_price,
datetime_finish, bet_increment, lot_category, lot_owner)
VALUES
('2018-09-25 15:11:00', '2014 Rossignol District Snowboard', 'lorem ipsum', 'img/lot-1.jpg', 10999, 11500, '2018-10-25 15:11:00', 500, 1, 1),
('2018-09-25 15:12:00', 'DC Ply Mens 2016/2017 Snowboard', 'lorem ipsum', 'img/lot-2.jpg', 159999, 159999, '2018-10-25 15:11:00', 500, 1, 1),
('2018-09-25 15:13:00', 'Крепления Union Contact Pro 2015 года размер L/XL', 'lorem ipsum', 'img/lot-3.jpg', 8000, 8000, '2018-10-25 15:11:00', 500, 2, 1),
('2018-09-25 15:14:00', 'Ботинки для сноуборда DC Mutiny Charocal', 'lorem ipsum', 'img/lot-4.jpg', 10999, 10999, '2018-10-25 15:11:00', 500, 3, 1),
('2018-09-25 15:15:00', 'Куртка для сноуборда DC Mutiny Charocal', 'lorem ipsum', 'img/lot-5.jpg', 7500, 7500, '2018-10-25 15:11:00', 500, 4, 1),
('2018-09-25 15:16:00', 'Маска Oakley Canopy', 'lorem ipsum', 'img/lot-6.jpg', 5400, 6000, '2018-10-25 15:11:00', 500, 6, 1);

INSERT INTO bets(bet_datetime, bet_sum, bet_owner, bet_lot)
VALUES
('2018-09-25 18:41:17', 11500, 2, 1),
('2018-09-25 18:43:17', 6000, 2, 6);

/* получить все категории */
SELECT cat_title FROM categories;

/* получить самые новые, открытые лоты. Каждый лот должен включать название,
стартовую цену, ссылку на изображение, цену, количество ставок, название категории; */
SELECT lots.lot_title, starting_price, current_price, lot_picture, cat_title, COUNT(bets.bet_id) as bets_quantity
FROM lots
LEFT JOIN categories ON cat_id = lot_category
LEFT JOIN bets ON lots.lot_id = bets.bet_lot
WHERE datetime_finish > CURRENT_TIMESTAMP
GROUP BY lot_id
ORDER BY datetime_start DESC;

/* показать лот по его id. Получите также название категории, к которой принадлежит лот */
SELECT lot_title, cat_title
FROM lots, categories
WHERE lot_id = 3
AND lot_category = cat_id;

/* обновить название лота по его идентификатору */
UPDATE lots SET lot_title = 'New Lot Title'
WHERE lot_id = 6;

/* получить список самых свежих ставок для лота по его идентификатору */
SELECT bet_datetime, bet_sum, username, lot_title
FROM bets, users, lots
WHERE bet_lot = 1 AND bet_lot = lot_id AND bet_owner = user_id
ORDER BY bet_datetime DESC;
