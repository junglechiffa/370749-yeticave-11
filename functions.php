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

	    if ($m_price[0]["m_price"] == '') {
	        $lots[$k]["m_price"] = $value["cost_start"];
	    }else{
	        $lots[$k]["m_price"] = $m_price[0]["m_price"];
	    }          
	}
	return $lots;
}

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}
/**
 * 
 */
function db_fetch_data($link, $sql, $data = []){
	$result = [];
	$stmt = db_get_prepare_stmt($link, $sql, $data);
	$res = mysqli_execute($stmt);
	if($res){
		$result = mysql_fetch_all($res, MYSQLI_ASSOC);
	}
	return $result;
}
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}
?>