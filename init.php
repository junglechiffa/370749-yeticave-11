<?php

$is_auth = rand(0, 1);
$user_name = 'Алексей';
$db_access = [
	'host' => "localhost",
	'login' => "root",
	'password' => ''
];
$db_name = "yeti";
$db_connect = db_connect($db_access, $db_name);
?>