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
		l.`name`,
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
WHERE l.`id` = '1'

/**
 * обновить название лота по его идентификатору;
 */
UPDATE `lot`
SET `name` = 'измененное_имя'
WHERE `id` = '1'

/**
 * получить список ставок для лота по его идентификатору с сортировкой по дате.
 */
 SELECT `id`,
	`data_add`,
	`price`,
	`user_id`,
	`lot_id`
 FROM `rate`
 WHERE `lot_id` = '1'
 ORDER BY `data_add`
