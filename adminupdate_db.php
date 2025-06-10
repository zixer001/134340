<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id_ad"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'staff.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$id_ad = $_POST["id_ad"];
	$username_ad = $_POST["username_ad"];
	$password_ad = md5($_POST["password_ad"]);
	$phone_ad = $_POST["phone_ad"];
	$name_ad = $_POST["name_ad"];
	
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE admin SET  
			username_ad='$username_ad' ,
			password_ad='$password_ad' , 
			phone_ad='$phone_ad' ,
			name_ad='$name_ad' 
			WHERE id_ad='$id_ad' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'staff.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'staff.php'; ";
	echo "</script>";
}
?>