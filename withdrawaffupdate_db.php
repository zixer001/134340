<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'withdrawaff.php'; "; 
echo "</script>";

}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$id = $_POST["id"];
	
	$amount_aff = $_POST["amount_aff"];
	$phone_aff = $_POST["phone_aff"];
	$bank_aff = $_POST["bank_aff"];	
	$bankacc_aff = $_POST["bankacc_aff"];
	$name_aff = $_POST["name_aff"];
	$confirm_aff = $_POST["confirm_aff"];
	$note_aff = $_POST["note_aff"];
	$bankout_aff = $_POST["bankout_aff"];
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE withdrawaff SET  
			
			amount_aff='$amount_aff' , 
			phone_aff='$phone_aff' ,
			bank_aff='$bank_aff' ,
			bankacc_aff='$bankacc_aff' ,
			name_aff='$name_aff' ,
			confirm_aff='$confirm_aff' ,
			note_aff='$note_aff' ,
			bankout_aff='$bankout_aff'
			WHERE id='$id' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'withdrawaff.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'withdrawaff.php'; ";
	echo "</script>";
}
?>