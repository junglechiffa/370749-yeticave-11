<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('data.php');
$db_connect = db_connect ($db_access, $db_name);
//Получение категорий 
$category_list = " SELECT * FROM `category`";
$category_list = db_sel($db_connect, $category_list);
// Проверка, существует ли параметр и не пустой ли он.
if (!isset($_GET['lot_id']) or empty($_GET['lot_id'])){
	echo "1";
	$error = "404";
	$page_content = include_template('error.php', ['error' => $error]);
}else{
	echo "2";
	//Получение из базы информации по лоту.
	$lot = '
	    SELECT l.id, l.name, cost_start, picture, c.name AS c_name, l.data_end, text, cost_step
	    FROM lot l
	    INNER JOIN category c ON l.category_id = c.id
	    WHERE l.id = ' .$_GET["lot_id"]. '';
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
	echo "3";
	$error = "404";
	$page_content = include_template('error.php', [
		'error' => $error]
	);
}else{
	echo "4";
	$page_content = include_template ('lot_t.php', [
	    'categorys' => $category_list,
	    'lot' => $lot['0']
	]);
}
$layout_content = include_template ('layout.php', [
    'categorys' => $category_list,
    'page_content' => $page_content,
    'user_name' => $user_name,
    'title' => $title
]);

print($layout_content);

?>