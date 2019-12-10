<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');

//Получение категорий 
$category_list = " SELECT * FROM `category`";
$category_list = db_sel($db_connect, $category_list);
// Проверка, существует ли параметр и не пустой ли он.
if (!isset($_GET['lot_id']) or empty($_GET['lot_id'])){

	$lot = '
	    SELECT l.id, l.name, cost_start, picture, c.name AS c_name, l.data_end, text, cost_step
	    FROM lot l
	    INNER JOIN category c ON l.category_id = c.id

	$lot = db_sel($db_connect, $lot);
	$lot = add_max_price($db_connect, $lot);
	/*
	echo '<pre>'; 
	print_r($lot['0']);
	echo '</pre>';
	*/
}
//Проверка, есть ли запись в базе по айди из параметра или нет.
if (!$lot or $lot == ''){

	$error = "404";
	$page_content = include_template('error.php', [
		'error' => $error]
	);
}else{

	    'categorys' => $category_list,
	    'lot' => $lot['0']
	]);
}

    'categorys' => $category_list,
    'page_content' => $page_content,
    'user_name' => $user_name,
    'title' => $title
]);

print($layout_content);

?>