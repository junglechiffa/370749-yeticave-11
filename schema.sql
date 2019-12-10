
create database yeti
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
use yeti;

CREATE TABLE `yeti`.`category` ( 
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`name` VARCHAR(255) NOT NULL, 
	`name_code` VARCHAR(255) NOT NULL
) ENGINE = MyISAM;

CREATE TABLE `yeti`.`lot` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`data_start` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`data_end` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`name` VARCHAR(255) NOT NULL,
	`text` TEXT NOT NULL,
	`picture` VARCHAR(255) NOT NULL,
	`cost_start` INT NOT NULL,
	`cost_step` INT NOT NULL,
	`user_id` INT NOT NULL,
	`winner_id` INT NOT NULL,
	`category_id` INT NOT NULL
) ENGINE = MyISAM;

CREATE TABLE `yeti`.`rate` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`data_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`price` INT NOT NULL,
	`user_id` INT NOT NULL,
	`lot_id` INT NOT NULL
) ENGINE = MyISAM;

CREATE TABLE `yeti`.`user` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`data_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`email`  VARCHAR(255) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`contact` VARCHAR(255) NOT NULL
) ENGINE = MyISAM;


CREATE UNIQUE INDEX name ON category(name);
CREATE UNIQUE INDEX name_code ON category(name_code);

CREATE UNIQUE INDEX lot_name ON lot(name);
CREATE INDEX cost_start ON lot(cost_start);
CREATE INDEX cost_step ON lot(cost_step);
CREATE INDEX user_id ON lot(user_id);
CREATE INDEX winner_id ON lot(winner_id);
CREATE INDEX category_id ON lot(category_id);

CREATE INDEX price ON rate(price);
CREATE INDEX usercreator_id ON rate(user_id);
CREATE INDEX lot_id ON rate(lot_id);

CREATE UNIQUE INDEX email ON user(email);
CREATE UNIQUE INDEX user_name ON user(name);
CREATE UNIQUE INDEX password ON user(password);
CREATE UNIQUE INDEX contact ON user(contact);
