<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('init.php');
$db_connect = db_connect ($db_access, $db_name);
//Получение категорий 
$category_list = " SELECT * FROM `category`";
$category_list = db_sel($db_connect, $category_list);

$page_content = include_template ('add_t.php', [
	    'categorys' => $category_list
	]);
$layout_content = include_template ('layout.php', [
    'categorys' => $category_list,
    'page_content' => $page_content,
    'user_name' => $user_name,
    'title' => $title
]);

print($layout_content);
?>