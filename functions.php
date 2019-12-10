<?php

/**
 * Форматирование числа (цены)
 */
function format_numb($number){
    $number = ceil($number);
    if ($number < 1000) {
        return $number . ₽;
    }elseif($number >= 1000){
        $number = number_format ( $number , 0, ".", " ");
        return $number . '₽';
    }
}

/**
 * Подключение шаблонов
 */
function include_template($name, $data){
	$name = 'templates/' . $name;
	$result = '';

	if (!file_exists($name)) {
		return $result;
	}

	ob_start();
	extract($data);
	require $name;

	$result = ob_get_clean();

	return $result;
}

/**
 * Время до закрытия лота ЧЧ:ММ
 */
function lifetime($endtime){
	
	$now = time();
	$endtime = strtotime($endtime);
	//return "$now";
	//return "$endtime";

	$lifetime_hours = floor(($endtime - $now) / 3600);
	$lifetime_minutes = floor((($endtime - $now) % 3600)/60);
	if ($lifetime_hours < 10) {
		$lifetime_hours = str_pad($lifetime_hours, 2, "0", STR_PAD_LEFT);
	}
	if ($lifetime_minutes < 10) {
		$lifetime_minutes = str_pad($lifetime_minutes, 2, "0", STR_PAD_LEFT);
	}
	$lifetime = [$lifetime_hours, $lifetime_minutes];
	return $lifetime;
}	
/**
 * Подключение к базе
 */
function db_connect ($db_access, $db_name){
	$db_connect = mysqli_connect($db_access['host'], $db_access['login'], $db_access['password'], $db_name);
	if ($db_connect == false) {
    print("Ошибка подключения" . mysqli_connect_error());
	} 
	else {
	    //print("Соединение установлено");
	    return $db_connect;
	}

	mysqli_set_charset($con, "utf-8");
}
/**
 * Получение записей из базы как двумерный массив
 */
function db_sel ($db_connect, $sql){
	$query = mysqli_query($db_connect, $sql);

	if (!$query) {
	    $error = mysqli_error($db_connect);
	    print ($error);
	}

	$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
	return $rows;
}
/**
 * Добавление цены в массив лота
 */
function add_max_price($db_connect, $lots){
	foreach ($lots as $k => $value) {
	    $m_price = '
	        SELECT MAX(price) AS m_price
	        FROM rate r
	        WHERE r.lot_id = '.$value["id"].'';

	    $m_price = db_sel($db_connect,$m_price);

	    if ($m_price[0]["m_price"] == '') {
	        $lots[$k]["m_price"] = $value["cost_start"];
	    }else{
	        $lots[$k]["m_price"] = $m_price[0]["m_price"];
	    }          
	}
	return $lots;
}
?>


