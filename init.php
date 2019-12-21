<?php
session_start();
$db_access = [
	'host' => "localhost",
	'login' => "root",
	'password' => ''
];
$db_name = "yeti";
$db_connect = db_connect($db_access, $db_name);
?>