<?php
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
	//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม
	
  $name_pro = $_POST["name_pro"];
  $dp_pro = $_POST["dp_pro"];
	$bonus_pro = $_POST["bonus_pro"];
	$bonusper_pro = $_POST["bonusper_pro"];
	$games_pro = $_POST["games_pro"];
	$turn_pro = $_POST["turn_pro"];
	$rules_pro = $_POST["rules_pro"];
	$wd_pro = $_POST["wd_pro"];
	$time_pro = $_POST["time_pro"];
	$max_pro = $_POST["max_pro"];
 
//ฟังก์ชั่นวันที่
  date_default_timezone_set('Asia/Bangkok');
	$date = date("Ymd");	
//ฟังก์ชั่นสุ่มตัวเลข
         $numrand = (mt_rand());
//เพิ่มไฟล์
$upload=$_FILES['fileupload_pro'];
if($upload <> '') {   //not select file
//โฟลเดอร์ที่จะ upload file เข้าไป 
$path="../slip/";  
 
//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
 $type = strrchr($_FILES['fileupload_pro']['name'],".");
	
//ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
$newname = $date.$numrand.$type;
$path_copy=$path.$newname;
$path_link="../slip/".$newname;
 
//คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
move_uploaded_file($_FILES['fileupload_pro']['tmp_name'],$path_copy);  	
	}

	

	$sql = "INSERT INTO promotion (name_pro, fileupload_pro, dp_pro, bonus_pro, games_pro, turn_pro, rules_pro, wd_pro, time_pro, bonusper_pro, max_pro)
			 VALUES('$name_pro', '$newname', '$dp_pro', '$bonus_pro', '$games_pro', '$turn_pro', '$rules_pro', '$wd_pro', '$time_pro', '$bonusper_pro', '$max_pro')";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('เพิ่มโปรโมชั่นเรียบร้อย');";
	echo "window.location = 'promotion.php'; ";
	echo "</script>";
	}
	else{
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to deposit again');";
	echo "</script>";
}
?>