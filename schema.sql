CREATE database yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
  cat_id INT AUTO_INCREMENT PRIMARY KEY,
  cat_title VARCHAR(512) UNIQUE
);
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  registration_date TIMESTAMP,
  email CHAR(128) UNIQUE,
  username VARCHAR(512) UNIQUE,
  password VARCHAR(64),
  user_pic TEXT,
  contacts TEXT,
  created_lots INT,
  placed_bets INT
);
CREATE TABLE lots (
  lot_id INT AUTO_INCREMENT PRIMARY KEY,
  datetime_start TIMESTAMP,
  lot_title VARCHAR(512),
  description TEXT,
  lot_picture VARCHAR(512),
  starting_price INT,
  current_price INT,
  datetime_finish TIMESTAMP,
  bet_increment INT,
  lot_category INT,
  lot_owner INT,
  lot_winner INT,
  FOREIGN KEY (lot_category) REFERENCES categories(cat_id),
  FOREIGN KEY (lot_owner) REFERENCES users(user_id),
  FOREIGN KEY (lot_winner) REFERENCES users(user_id)
);
CREATE TABLE bets (
  bet_id INT AUTO_INCREMENT PRIMARY KEY,
  bet_datetime TIMESTAMP,
  bet_sum INT,
  bet_owner INT,
  bet_lot INT,
  FOREIGN KEY (bet_owner) REFERENCES users(user_id),
  FOREIGN KEY (bet_lot) REFERENCES lots(lot_id)
);
