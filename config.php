<?php

$host = "localhost";
$user = "goldoejd_second";
$password = "Chubooy000@123";
$database = "goldoejd_app";
$charset = "UTF8";

$connect = mysqli_connect($host, $user, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($connect, $charset);

?>