CREATE database yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(512) UNIQUE
);
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registration_date TIMESTAMP,
  email CHAR(128) UNIQUE,
  username VARCHAR(512) UNIQUE,
  password VARCHAR(64),
  userpic TEXT,
  contacts TEXT,
  created_lots INT,
  placed_bets INT,
  token VARCHAR(64)
);
CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  datetime_start TIMESTAMP,
  title VARCHAR(512),
  description TEXT,
  picture VARCHAR(512),
  starting_price INT,
  current_price INT,
  datetime_finish TIMESTAMP,
  bet_increment INT,
  category INT,
  owner INT,
  winner INT,
  FOREIGN KEY (category) REFERENCES categories(id),
  FOREIGN KEY (owner) REFERENCES users(id),
  FOREIGN KEY (winner) REFERENCES users(id)
);
CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  datetime TIMESTAMP,
  bet INT,
  owner INT,
  lot INT,
  FOREIGN KEY (owner) REFERENCES users(id),
  FOREIGN KEY (lot) REFERENCES lots(id)
);
