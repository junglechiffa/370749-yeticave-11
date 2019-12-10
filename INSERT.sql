



INSERT INTO `category` (
	`name`, 
	`name_code`
)
	VALUES(
			'Доски и лыжи',
			'Boards and skis'
		),
		(
			'Крепления',
			'Mounts'
		),
		(
			'Ботинки',
			'Boots'
		),
		(
			'Одежда',
			'clothing'
		),
		(
			'Инструменты',
			'Instruments'
		),
		(
			'Разное',
			'other'
		)


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
			'1'
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
			'1'
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
			'2'
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
			'3'
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
			'4'
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
			'6'
		)




