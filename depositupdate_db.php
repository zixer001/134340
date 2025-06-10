<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'deposit.php'; "; 
echo "</script>";

}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$id2 = $_POST["id"];
	
	$amount_dp = $_POST["amount_dp"];
	$bankin_dp = $_POST["bankin_dp"];
	$phone_dp = $_POST["phone_dp"];
	$bank_dp = $_POST["bank_dp"];	
	$bankacc_dp = $_POST["bankacc_dp"];
	$name_dp = $_POST["name_dp"];
	$confirm_dp = $_POST["confirm_dp"];
	$note_dp = $_POST["note_dp"];
	$turnover = $_POST["turnover"];
	$promotion_dp = $_POST["promotion_dp"];
	$bonus_dp = $_POST["bonus_dp"];
	
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE deposit SET  
			
			amount_dp='$amount_dp' , 
			bankin_dp='$bankin_dp' ,
			phone_dp='$phone_dp' ,
			bank_dp='$bank_dp' ,
			bankacc_dp='$bankacc_dp' ,
			name_dp='$name_dp' ,
			confirm_dp='$confirm_dp' ,
			promotion_dp='$promotion_dp' ,
			note_dp='$note_dp' ,
			bonus_dp='$bonus_dp' ,
			turnover='$turnover'
			WHERE id='$id2' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'deposit.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'deposit.php'; ";
	echo "</script>";
}
?>