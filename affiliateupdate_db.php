<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'member.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
$id = $_POST["id"];
$username = $_POST["username"];
	$password = $_POST["password"];
  $phone = $_POST["phone"];
  $bank = $_POST["bank"];
	$bankacc = $_POST["bankacc"];
	$name = $_POST["name"];
	$status = $_POST["status"];


  $percent = $_POST["percent"];
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE affiliate SET  
			username='$username' ,
			password='$password' , 
			phone='$phone' ,
			percent='$percent' ,
			bank='$bank' ,
			bankacc='$bankacc' ,
			name='$name' ,
			status='$status'
			WHERE id='$id' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'affiliate.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'affiliate.php'; ";
	echo "</script>";
}
?>