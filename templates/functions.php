<?php

/**
 * Форматирование числа (цены)
 */
function format_numb($number){
    $number = ceil($number);
    if ($number < 1000) {
        return $number .₽;  
    }elseif($number >= 1000){
        $number = number_format ( $number , 0 ,"."," " );

        return $number ." ₽";
    }
}

        return $number . ₽;
    }
}




/**
 * Подключение шаблонов
 */
function include_template($name,$data){
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


