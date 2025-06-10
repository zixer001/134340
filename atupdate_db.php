<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'activity.php'; "; 
echo "</script>";

}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$id2 = $_POST["id"];
	$name_at = $_POST["name_at"];
	$detail_at = $_POST["detail_at"];
	$status_at = $_POST["status_at"];
	$amount_at = $_POST["amount_at"];
	$credit_at = $_POST["credit_at"];
	$turnover_at = $_POST["turnover_at"];
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE activity SET  
			name_at='$name_at' ,
			detail_at='$detail_at' ,
			status_at='$status_at',
			amount_at='$amount_at',
			credit_at = '$credit_at',
			turnover_at = '$turnover_at'
			WHERE id='$id2' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'activity.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'activity.php'; ";
	echo "</script>";
}
?>