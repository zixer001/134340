<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
include '../func.php';
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if ($_POST["id"] == '') {
	echo "<script type='text/javascript'>";
	echo "alert('Error Contact Admin !!');";
	echo "window.location = 'withdraw.php'; ";
	echo "</script>";
}
$sql4 = "SELECT * FROM setting";
$result4 = mysqli_query($con, $sql4) or die("Error in query: $sql " . mysqli_error());
$row4 = mysqli_fetch_array($result4);

$agent = $row4['agent'];
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
$id = $_POST["id"];

$amount_wd = $_POST["amount_wd"];
$phone_wd = $_POST["phone_wd"];
$bank_wd = $_POST["bank_wd"];
$bankacc_wd = $_POST["bankacc_wd"];
$name_wd = $_POST["name_wd"];
$confirm_wd = $_POST["confirm_wd"];
$note_wd = $_POST["note_wd"];
$bankout_wd = $_POST["bankout_wd"];
$username_mb = $_POST["username"];
//echo $amount_wd;


$sql = "UPDATE withdraw SET  
			
			amount_wd='$amount_wd' , 
			phone_wd='$phone_wd' ,
			bank_wd='$bank_wd' ,
			bankacc_wd='$bankacc_wd' ,
			name_wd='$name_wd' ,
			confirm_wd='$confirm_wd' ,
			note_wd='$note_wd' ,
			pin_wd='' ,
			bankout_wd='$bankout_wd'
			WHERE id='$id' ";

$result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error());

if ($result == true) {

	if ($confirm_wd == 'ปฏิเสธ') {
		include ROOTPATH . 'class/betflix.php';
		$api = new Betflix();
		$data = $api->deposit($username_mb, $amount_wd);
		echo $status;
		if (!$data->error_code) {
			echo "<script type='text/javascript'>";
			echo "alert('Update Succesfuly');";
			echo "window.location = 'withdraw.php'; ";
			echo "</script>";
		} else {
			echo "<script type='text/javascript'>";
			echo "alert('Error back to Update again');";
			echo "window.location = 'withdraw.php'; ";
			echo "</script>";
		}
	} else {
		echo "<script type='text/javascript'>";
		echo "alert('Update Succesfuly');";
		echo "window.location = 'withdraw.php'; ";
		echo "</script>";
	}
}
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
