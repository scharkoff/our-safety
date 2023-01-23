<?php

$db_host = 'std-mysql.ist.mospolytech.ru';
$db_username = 'std_2021_our_safety';
$db_password = '123321zsq';
$db_name = 'std_2021_our_safety';

$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$connect) {
    die("Не удалось подключиться к базе данных! Проверьте правильность данных. Код ошибки: ".mysqli_connect_error());
}

?>