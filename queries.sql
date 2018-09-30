INSERT INTO categories(title)
VALUES
('Доски и лыжи'),
('Крепления'),
('Ботинки'),
('Одежда'),
('Инструменты'),
('Разное');

INSERT INTO users(registration_date, email, username, password, userpic, contacts, created_lots, placed_bets)
VALUES
('2018-09-25 10:10:10', 'vovka_kuchkin@qmail.ru', 'Виктор Палыч', 'qwerty', NULL, 'телефон 123456', NULL, NULL),
('2018-08-17 05:41:21', 'alex999@qmail.ru', 'A L E X', 'asdfgh', NULL, 'skype alexandr223334s', NULL, NULL);

INSERT INTO lots(datetime_start, title, description, picture, starting_price, current_price,
datetime_finish, bet_increment, category, owner)
VALUES
('2018-09-25 15:11:00', '2014 Rossignol District Snowboard', 'lorem ipsum', 'img/lot-1.jpg', 10999, 11500, '2018-10-25 15:11:00', 500, 1, 1),
('2018-09-25 15:12:00', 'DC Ply Mens 2016/2017 Snowboard', 'lorem ipsum', 'img/lot-2.jpg', 159999, 159999, '2018-10-25 15:11:00', 500, 1, 1),
('2018-09-25 15:13:00', 'Крепления Union Contact Pro 2015 года размер L/XL', 'lorem ipsum', 'img/lot-3.jpg', 8000, 8000, '2018-10-25 15:11:00', 500, 2, 1),
('2018-09-25 15:14:00', 'Ботинки для сноуборда DC Mutiny Charocal', 'lorem ipsum', 'img/lot-4.jpg', 10999, 10999, '2018-10-25 15:11:00', 500, 3, 1),
('2018-09-25 15:15:00', 'Куртка для сноуборда DC Mutiny Charocal', 'lorem ipsum', 'img/lot-5.jpg', 7500, 7500, '2018-10-25 15:11:00', 500, 4, 1),
('2018-09-25 15:16:00', 'Маска Oakley Canopy', 'lorem ipsum', 'img/lot-6.jpg', 5400, 6000, '2018-10-25 15:11:00', 500, 6, 1);

INSERT INTO bets(datetime, bet, owner, lot)
VALUES
('2018-09-25 18:41:17', 11500, 2, 1),
('2018-09-25 18:43:17', 6000, 2, 6);

/* получить все категории */
SELECT title FROM categories;

/* получить самые новые, открытые лоты. Каждый лот должен включать название,
стартовую цену, ссылку на изображение, цену, количество ставок, название категории; */
SELECT l.title, starting_price, current_price, picture, c.title, COUNT(b.id) as bets_quantity
FROM lots l
LEFT JOIN categories c ON c.id = category
LEFT JOIN bets b ON l.id = b.lot
WHERE datetime_finish > CURRENT_TIMESTAMP
GROUP BY l.id
ORDER BY datetime_start DESC;

/* показать лот по его id. Получите также название категории, к которой принадлежит лот */
SELECT l.title, c.title
FROM lots l, categories c
WHERE l.id = 3
AND l.category = c.id;

/* обновить название лота по его идентификатору */
UPDATE lots l SET l.title = 'New Lot Title'
WHERE l.id = 6;

/* получить список самых свежих ставок для лота по его идентификатору */
SELECT datetime, bet, username, l.title
FROM bets b, users u, lots l
WHERE b.lot = 1 AND b.lot = l.id AND b.owner = u.id
ORDER BY datetime DESC;
