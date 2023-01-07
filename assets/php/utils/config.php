<?php

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'our_safety';
$db_charset = 'utf8';

$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$connect) {
    die("Не удалось подключиться к базе данных! Проверьте правильность данных. Код ошибки: ".mysqli_connect_error());
}

?>