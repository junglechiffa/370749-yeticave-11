<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('init.php');
$debug = 1;
//Получение категорий 
$category_list = " SELECT * FROM `category`";
$category_list = db_sel($db_connect, $category_list);

if (isset($_GET) and !empty($_GET)) {
	$search = htmlspecialchars(addslashes(trim($_GET['search'])));
	echo $search;
	
	$sql = "SELECT l.id AS id, data_end, l.name, picture, cost_start, c.name AS c_name
			FROM lot l JOIN category c ON l.category_id = c.id
			WHERE MATCH(l.name, l.text) AGAINST('".$search."') 
	";
	$lot = db_sel($db_connect, $sql);
	$lot = add_max_price($db_connect, $lot);
	//Получить колличество ставок
	foreach ($lot as $key => $value) {
		$price_status = "
	        SELECT count(*) AS price_status
	        FROM rate r
	        WHERE r.lot_id = '".$value['id']."'
		";
		$price_status = db_sel($db_connect,$price_status);
		$price_status = $price_status[0];
	    if ($price_status['price_status'] > 0) {
	        $lot[$key]['price_status'] = $price_status['price_status']." ставок";
	    }elseif ($price_status['price_status'] == 0) {
	    	$lot[$key]['price_status'] = "Стартовая цена";
	    }
	      
	}
	
}



//search.php/?search=искомое

































if ($debug == 1) {

	echo '<pre>'; 
	print_r($price_status);
	echo '</pre>';

	echo '<pre>'; 
	print_r($lot);
	echo '</pre>';
}
	

//}


//Проверка, есть ли запись в базе по айди из параметра или нет.
if (!$lot or $lot == ''){
	//echo "3";
	$error = "Ничего не найдено по вашему запросу";
	$page_content = include_template('error.php', [
		'error' => $error]
	);
}else{
	//echo "4";
	$page_content = include_template('search-t.php', [
	    'categorys' => $category_list,
	    'lot' => $lot,
	    'search' => $search
	]);
}
$layout_content = include_template('layout.php', [
    'categorys' => $category_list,
    'page_content' => $page_content,
    'search' => $search,
    'user_name' => $user_name,
    'title' => $title
]);

print($layout_content);

?>