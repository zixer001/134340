<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'promotion.php'; "; 
echo "</script>";

}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$id2 = $_POST["id"];
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
	
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE promotion SET  
			name_pro='$name_pro' ,
			dp_pro='$dp_pro' ,
			bonus_pro='$bonus_pro' ,
			bonusper_pro='$bonusper_pro' ,
			games_pro='$games_pro' ,
			turn_pro='$turn_pro' ,
			rules_pro='$rules_pro' ,
			time_pro='$time_pro' ,
			max_pro='$max_pro' ,
			wd_pro='$wd_pro' 
			WHERE id='$id2' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'promotion.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'promotion.php'; ";
	echo "</script>";
}
?>