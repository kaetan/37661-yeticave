CREATE database yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;
CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  datetime_start TIMESTAMP,
  title VARCHAR(512),
  description TEXT,
  picture VARCHAR(512),
  starting_price INT,
  datetime_finish TIMESTAMP,
  bid_increment INT,
  category_id INT,
  owner_id INT,
  winner_id INT,
  KEY (category_id, title)
);
CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(512) UNIQUE
);
CREATE TABLE bid (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bid_datetime TIMESTAMP,
  bid_sum INT,
  bidder_id INT,
  lot_id INT
);
CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registration_date TIMESTAMP,
  email CHAR(128) UNIQUE,
  username VARCHAR(512) UNIQUE,
  password VARCHAR(64),
  user_pic TEXT,
  contacts TEXT,
  created_lots INT,
  placed_bids INT
);