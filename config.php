<?php
$host = "localhost";

$user = "root"; //db user

$pass = ""; //db pass

$db = "test_db"; //db 



$path='http://'.$_SERVER['SERVER_NAME']."/";

echo $path;

$server = mysqli_connect($host,$user,$pass,$db);

if(!$server){

	die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ!" .mysqli_error());

}

mysqli_set_charset($server,"utf8");



?>