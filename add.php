<?php
date_default_timezone_set("Europe/Moscow");
session_start();
require_once('functions.php');
require_once('init.php');

//Получение категорий 
$category_list = " SELECT * FROM `category`";
$category_list = db_sel($db_connect, $category_list);
$error = [];
// 0 - отключен, 1 - отладка
$debug = 0;

//полная очистка массива пост от потенциално опасных символов
if (isset($_POST) and !empty($_POST)){
	foreach ($_POST as $k => $v){
		if (!is_array($v)) {
			$_POST[$k] = htmlspecialchars(addslashes($v));
		}else{
			$_POST[$k] = '';
		}
	}
	$lot = [];
	//назначение переменных для вставки в запрос
	$lot_name = trim($_POST['lot-name']);
	$category = intval($_POST['category']);
	$message= trim($_POST['message']);
	$lot_rate = intval(trim($_POST['lot-rate']));
	$lot_step = intval(trim($_POST['lot-step']));
	$lot_date = $_POST['lot-date'] . " 00:00:00"; 
	$lot_pic = $_FILES['lot_pic']['tmp_name']; 
	$lot = ["lot_name" => $lot_name, "category" => $category, "message" => $message, "lot_rate" => $lot_rate, "lot_step" => $lot_step, "lot_date" => $lot_date, "lot_pic" => $lot_pic];

	// проверка всех полей на пустоту
	foreach ($lot as $k => $v) {
		if (trim($v) == '') {
			$error[$k] = "Поле обязательно для заполнения";
		}
	}
	// Проверка имени на длину
	if (strlen($lot_name) > 25) {
		$error['lot_name'] = "Имя слишком длинное";
	}
	// Проверка описания на длину
	if (strlen($message) > 500) {
		$error['message'] = "Максимальная длина описания 500 символов.";
	}
	// Проверка категории на существование
	$isset_id = "SELECT * FROM category WHERE id ='$category'";
	if (!db_sel($db_connect,$isset_id)){
		$error['category'] = "Указана несуществующая категория";
	}
	// Содержимое поля «начальная цена» должно быть числом больше нуля
	if ($lot_rate < 1) {
		$error['lot_rate'] = "Цена должна быть больше или равна нулю";
	}
	// Содержимое поля «дата завершения» должно быть датой в формате «ГГГГ-ММ-ДД»;
	// Проверять, что указанная дата больше текущей даты, хотя бы на один день.
	$next_day = time() + (24 * 60 * 60);
	$l_date = strtotime($_POST['lot-date']);
	if (!is_date_valid($_POST['lot-date'])) {
		$error['lot_date'] = "Неверный формат даты";
	}elseif($l_date < $next_day){
		$error['lot_date'] = "Минимальное время жизни лота - 24 часа";
	}
// Содержимое поля «шаг ставки» должно быть целым числом больше нуля.

	if (intval($lot_step) < 1) {
		$error['lot_step'] = "Содержимое поля «шаг ставки» должно быть целым числом больше ноля.";
	}

	//загрузка файла на сервер
	if (!empty($_FILES["lot_pic"]["tmp_name"]) and empty($error)){
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $_FILES["lot_pic"]["tmp_name"]);
		//echo "file_type = ". $file_type;
		if ($file_type = "image/jpeg" or $file_type = "image/png") {
			$target_dir = "uploads/";
			$filename =uniqid() . '.jpg';
			$file_path = $target_dir . $filename;
			move_uploaded_file($_FILES["lot_pic"]["tmp_name"], $file_path);
		}else{
			$error['file'] = 'Допустимые форматы изображения jpeg/png';
		}
	}else{
		$error['file'] = 'Вы не добавили изображение или были найдены ошибки в других полях.';
	}

	if (empty($error)) {
		//Запрос на добавление нового лота
		$sql_nl = "INSERT INTO `lot` (
				`data_start`, 	
				`data_end`,
				`name`,  
				`text`, 
				`picture`,
				`cost_start`,
				`cost_step`,
				`user_id`,
				`category_id`) 
				VALUES (
				current_timestamp(), 
				'".$lot_date."',
				'".$lot_name."',
				'$message',
				'$file_path',
				'$lot_rate',
				'$lot_step',
				'$user_id',
				'$category'
			)";

		//Если лот добавлен, редирект на страницу лота. Если нет, ошибка sql
		if (mysqli_query($db_connect, $sql_nl)){
			if ($debug == 1) {
				echo "лот добавлен, нужен редирект";
			}
			$lot_id = mysqli_insert_id($db_connect);
			header("Location: /lot.php/?lot_id=" . $lot_id);
			die();
		}else{
			echo mysqli_error($db_connect);
		}
	}else{
		$_SESSION['error'] = $error;
		$_SESSION['lot'] = $lot;
		header("Location: /add.php");
	}

	if ($debug == 1) {
		echo '<pre>'. "пост"; 
		print_r($_POST);
		echo '</pre>';

		echo '<pre>'. "файл"; 
		print_r($_FILES);
		echo '</pre>';

		echo '<pre>'. "массив с лотом"; 
		print_r($lot);
		echo '</pre>';

		echo '<pre>'. "ошибки"; 
		print_r($error);
		echo '</pre>';
	}
}else{
	if (isset($_SESSION['error'])) {
		$error = $_SESSION['error'];
		unset($_SESSION['error']);
	}
	if (isset($_SESSION['lot'])) {
		$lot = $_SESSION['lot'];
		unset($_SESSION['lot']);
	}
}

$page_content = include_template ('add_t.php', [
	'categorys' => $category_list,
	'lot' => $lot,
	'error' => $error
]);

$layout_content = include_template ('layout.php', [
    'categorys' => $category_list,
    'page_content' => $page_content,
    'user_name' => $user_name,
    'title' => $title
]);

print($layout_content);

?>