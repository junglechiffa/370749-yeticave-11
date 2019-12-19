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

	//назначение переменных для вставки в запрос
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	$message= trim($_POST['message']);
	$name = trim($_POST['name']);
	$s_up = ["email" => $email, "password" => $password, "message" => $message, "name" => $name];
	$password_hash = password_hash($password, PASSWORD_DEFAULT);

	// Проверка всех полей на пустоту
	foreach ($s_up as $k => $v) {
		if (trim($v) == '') {
			$error[$k] = "Поле обязательно для заполнения";
		}
	}
	// Проверка на длину
	if (strlen($email) > 25) {
		$error['email'] = "Мейл слишком длинный";
	}
	if (strlen($password) > 25) {
		$error['password'] = "Пароль слишком длинный";
	}
	if (strlen($message) > 255) {
		$error['message'] = "Текст слишком длинный";
	}
	if (strlen($name) > 25) {
		$error['name'] = "Имя слишком длинное";
	}
	//На формат мейла
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$error['email'] = "Неправильный формат email";
	}
	// Проверка имени на уникальность
	$uniq_name = "SELECT count(*) FROM `user` WHERE `name` ='".$name."'";
	$uniq_name = db_sel($db_connect, $uniq_name);
	if ($uniq_name['0']['count(*)'] !== '0'){
		$error['name'] = "Пользователь с таким именем уже существует";
	}
	// Проверка мейла на уникальность
	$uniq_mail = "SELECT count(*) FROM `user` WHERE `email` ='".$email."'";
	$uniq_mail = db_sel($db_connect, $uniq_mail);
	if ($uniq_mail['0']['count(*)'] !== '0'){
		$error['email'] = "Пользователь с таким email уже зарегистрирован";
	}

	//Запрос на добавление нового пользователя
	if (empty($error)) {
		$sql_nl = "INSERT INTO `user` (
				`data_create`, 	
				`email`,
				`name`,  
				`password`, 
				`contact`) 
				VALUES (
				current_timestamp(), 
				'".$email."',
				'".$name."',
				'".$password_hash."',
				'".$message."'
			)";

		//Если успешно, редирект на главную страницу. Если нет, ошибка sql
		if (mysqli_query($db_connect, $sql_nl)){
			if ($debug == 1) {
				echo "пользователь добавлен, нужен редирект";
			}else{
				header("Location: /login.php");
			die();
			}
		}else{
			echo mysqli_error($db_connect);
		}
	}

	//Отладочная информация 
	if ($debug == 1) {

		echo "____________________________".$uniq_name['0']['count(*)'];

		echo '<pre>'. "пост"; 
		print_r($uniq_name);
		echo '</pre>';

		echo '<pre>'. "пост"; 
		print_r($_POST);
		echo '</pre>';

		echo '<pre>'. "s_up"; 
		print_r($s_up);
		echo '</pre>';

		echo '<pre>'. "ошибки"; 
		print_r($error);
		echo '</pre>';
	}
}

$page_content = include_template ('sign-up_t.php', [
	'categorys' => $category_list,
	's_up' => $s_up,
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