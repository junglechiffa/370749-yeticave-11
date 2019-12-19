



INSERT INTO `category` 
	SET name = 'Доски и лыжи', 
		name_code = 'Boards and skis';
INSERT INTO category 
	SET name = 'Крепления', 
		name_code = 'Mounts';
INSERT INTO category 
	SET name = 'Ботинки', 
		name_code = 'Boots';
INSERT INTO category 
	SET name = 'Одежда', 
		name_code = 'clothing';
INSERT INTO category 
	SET name = 'Инструменты', 
		name_code = 'Instruments';
INSERT INTO category 	
	SET name = 'Разное', 
		name_code = 'Miscellaneous';

/**
 * Придумайте пару пользователей
 */
INSERT INTO `user` (
	`data_create`, 
	`email`, 
	`name`, 
	`password`, 
	`contact`
) 
	VALUES 
		(
			current_timestamp(), 			
			'alesha@mail.ru',
			'Alesha', 
			'3984n2c9rc2w3crw3crsw3trsvwtvww', 
			'8 999 999 99 99'
		),
		( 
			current_timestamp(), 
			'ivanushka@gmail.com', 
			'Ivanushka', 
			'ergrgergavbe43634637t34twtv', 
			'8 999 888 88 88'
		)

/**
 * Существующий список объявлений
 */
INSERT INTO `lot` (

	`data_start`, 
	`data_end`, 
	`name`, 
	`text`, 
	`picture`, 
	`cost_start`, 
	`cost_step`, 
	`user_id`, 
	`winner_id`, 
	`category_id`
) 
	VALUES 
		(

			current_timestamp(), 
			current_timestamp(), 
			'2014 Rossignol District Snowboard', 
			'Описание', 
			'img/lot-1.jpg', 
			'10999', 
			'100', 
			'0', 
			'0', 
			'0'
		), 
		(

			current_timestamp(), 
			current_timestamp(), 
			'DC Ply Mens 2016/2017 Snowboard', 
			'Описание ', 
			'img/lot-2.jpg', 
			'159999', 
			'200', 
			'1', 
			'0', 
			'0'
		),
		(

			current_timestamp(), 
			current_timestamp(), 
			'Крепления Union Contact Pro 2015 года размер L/XL', 
			'Описание ', 
			'img/lot-3.jpg', 
			'8000', 
			'200', 
			'0', 
			'0', 
			'1'
		),
		(

			current_timestamp(), 
			current_timestamp(), 
			'Ботинки для сноуборда DC Mutiny Charocal', 
			'Описание ', 
			'img/lot-4.jpg', 
			'10999', 
			'200', 
			'1', 
			'0', 
			'2'
		),
		(

			current_timestamp(), 
			current_timestamp(), 
			'Куртка для сноуборда DC Mutiny Charocal', 
			'Описание ', 
			'img/lot-5.jpg', 
			'7500', 
			'200', 
			'0', 
			'0', 
			'3'
		),
		(
 
			current_timestamp(), 
			current_timestamp(), 
			'Маска Oakley Canopy', 
			'Описание ', 
			'img/lot-6.jpg', 
			'5400', 
			'200', 
			'1', 
			'0', 
			'5'
		)

/**
 * Добавьте пару ставок для любого объявления
 */
INSERT INTO `rate` (

	`data_add`, 
	`price`, 
	`user_id`,
	`lot_id`
)
	VALUES 
		(

			current_timestamp(), 
			'160199', 
			'0', 
			'1'
		), 
		(

			current_timestamp(), 
			'8200', 
			'1', 
			'2'
		)



/**
 * получить все категории;
 */
SELECT * FROM `category`

/**
 * получить самые новые, открытые лоты. 
 	Каждый лот должен включать:
	 	название, 
	 	стартовую цену, 
	 	ссылку на изображение, 
	 	текущую цену, 
	 	название категории;
 */
 SELECT l.`name`,
	 `cost_start`,
	 `picture`,
	 r.`price` AS r_price,
	 c.`name` AS c_name
 FROM lot l
 INNER JOIN rate r ON l.id = r.lot_id
 INNER JOIN category c ON l.`category_id` = c.`id`
 WHERE `data_end` > current_timestamp
 ORDER BY `data_start` DESC 

/**
 * показать лот по его id. Получите также название категории, к которой принадлежит лот;
 */
SELECT `data_start`,
		`data_end`,
		`lot`.`name`,
		`text`,
		`picture`,
		`cost_start`,
		`cost_step`,
		`user_id`,
		`winner_id`,
		c.`name` AS с_name
FROM lot l
INNER JOIN category c
ON l.`category_id` = c.`id`
WHERE l.`id` = 1

/**
 * обновить название лота по его идентификатору;
 */
UPDATE `lot`
SET `name` = "name2"
WHERE `id` = 1

/**
 * получить список ставок для лота по его идентификатору с сортировкой по дате.
 */
 SELECT `id`,
	`data_add`,
	`price`,
	`user_id`,
	`lot_id`
 FROM `rate`
 WHERE `lot_id` = 1
 ORDER BY `data_add`
