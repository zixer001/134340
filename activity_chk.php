<?php
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
	//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม
	
  $name_at = $_POST["name_at"];
  $detail_at = $_POST["detail_at"];
	$status_at = $_POST["status_at"];
	$amount_at = $_POST["amount_at"];
	$credit_at = $_POST["credit_at"];
	$turnover_at = $_POST["turnover_at"];
	
 
//ฟังก์ชั่นวันที่
  date_default_timezone_set('Asia/Bangkok');
	$date = date("Ymd");	
//ฟังก์ชั่นสุ่มตัวเลข
         $numrand = (mt_rand());
//เพิ่มไฟล์
$upload=$_FILES['fileupload_at'];
if($upload <> '') {   //not select file
//โฟลเดอร์ที่จะ upload file เข้าไป 
$path="../slip/";  
 
//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
 $type = strrchr($_FILES['fileupload_at']['name'],".");
	
//ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
$newname = $date.$numrand.$type;
$path_copy=$path.$newname;
$path_link="../slip/".$newname;
 
//คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
move_uploaded_file($_FILES['fileupload_at']['tmp_name'],$path_copy);  	
	}

	

	$sql = "INSERT INTO activity (name_at, fileupload_at, detail_at, status_at, amount_at, credit_at, turnover_at)
			 VALUES('$name_at', '$newname', '$detail_at', '$status_at', '$amount_at', '$credit_at', '$turnover_at')";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('เพิ่มกิจกรรมเรียบร้อย');";
	echo "window.location = 'activity.php'; ";
	echo "</script>";
	}
	else{
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to deposit again');";
	echo "</script>";
}
?>