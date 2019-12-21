<?php
date_default_timezone_set("Europe/Moscow");
require_once('functions.php');
require_once('init.php');

//Если пользователь уже авторизован
if (isset($_SESSION['user'])) {
  header("Location: /");
  die();
}



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
  $auth = ["email" => $email, "password" => $password];
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // Проверка всех полей на пустоту
  foreach ($auth as $k => $v) {
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
  //На формат мейла
  if ($auth['email'] !== "" AND !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error['email'] = "Неправильный формат email";
  }
  //Получаем массив с пользователем
  if (empty($error)) {
    $user = "SELECT * FROM `user` WHERE email = '".$email."' ";
    //       SELECT * FROM `user` WHERE email = 'alesha@mail.ru'
    $user = db_sel($db_connect, $user);
    if (!empty($user) and isset($user[0])) {
      if (password_verify($auth['password'], $user['0']['password'])) {
        $_SESSION['user'] = $user['0'];
      }else{
        $error['password'] = "Пароль указан не верно";
      }
    }else{
      $error['email'] = "Пользователя с таким email не существует";
    }
  }

  //Если успешно, редирект на главную страницу. 
  if (empty($error) and isset($_SESSION['user'])){
    if ($debug == 1) {
      echo "авторизация пройдена, нужен редирект";
    }else{
      header("Location: /");
      die();
    }
  }

  //Отладочная информация 
  if ($debug == 1) {

    echo '<pre>'. "сессия"; 
    print_r($_SESSION);
    echo '</pre>';


    echo '<pre>'. "user"; 
    if (is_array($user)) {
      print_r($user);
    }else{
      echo "1".$user;
    }
    echo '</pre>';

    echo '<pre>'. "пост"; 
    print_r($_POST);
    echo '</pre>';

    echo '<pre>'. "auth"; 
    print_r($auth);
    echo '</pre>';

    echo '<pre>'. "ошибки"; 
    print_r($error);
    echo '</pre>';
  }
}
echo '<pre>'. "сессия";
  echo "1";
  print_r($_SESSION['user']);
echo '</pre>';


$page_content = include_template ('login-t.php', [
  'categorys' => $category_list,
  'auth' => $auth,
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