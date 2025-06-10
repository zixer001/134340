<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id_mb"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'member.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$id_mb = $_POST["id_mb"];
	$username_mb = $_POST["username_mb"];
	$password_mb = $_POST["password_mb"];
	$phone_mb = $_POST["phone_mb"];
	$phone_true = $_POST["phone_true"];
	$bank_mb = $_POST["bank_mb"];	
	$bankacc_mb = $_POST["bankacc_mb"];
	$name_mb = $_POST["name_mb"];
	$confirm_mb = $_POST["confirm_mb"];
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE member SET  
			username_mb='$username_mb' ,
			password_mb='$password_mb' , 
			phone_mb='$phone_mb' ,
			phone_true='$phone_true' ,
			bank_mb='$bank_mb' ,
			bankacc_mb='$bankacc_mb' ,
			name_mb='$name_mb' ,
			confirm_mb='$confirm_mb'
			WHERE id_mb='$id_mb' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'member.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'member.php'; ";
	echo "</script>";
}
?>