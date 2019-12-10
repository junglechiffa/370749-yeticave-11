<?php

date_default_timezone_set("Europe/Moscow");


require_once('functions.php');
require_once('data.php');
$db_connect = db_connect ($db_access, $db_name);

//Отправьте SQL-запрос для получения списка новых лотов;
$new_lots = "
    SELECT l.id,l.name,cost_start,picture,c.name AS c_name,l.data_end
    FROM lot l
    INNER JOIN category c ON l.category_id = c.id
    WHERE data_end > current_timestamp
    ORDER BY data_start DESC 
    LIMIT 9";
$new_lots = db_sel($db_connect, $new_lots);

//Отправьте SQL-запрос для получения списка категорий;
$category_list = " SELECT * FROM `category`";
$category_list = db_sel($db_connect, $category_list);


//Добавление максимальной цены в массив с лотами
$new_lots = add_max_price($db_connect, $new_lots);
/*
echo '<pre>'; 
print_r($new_lots);
echo '</pre>';
*/
// Вывод шаблонов:
$page_content = include_template ('main.php', [
    'categorys' => $category_list,
    'new_lots' => $new_lots
]);
$layout_content = include_template ('layout.php', [
    'categorys' => $category_list,
    'page_content' => $page_content,
    'user_name' => $user_name,
    'title' => $title
]);
print($layout_content);
?>
