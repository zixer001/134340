<?php
//1. เชื่อมต่อ database: 
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'bank.php'; "; 
echo "</script>";

}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$id = $_POST["id"];
	$name_bank = $_POST["name_bank"];
	$bankacc_bank = $_POST["bankacc_bank"];
	$nameacc_bank = $_POST["nameacc_bank"];
	$bankfor = $_POST["bankfor"];
	$status_bank = $_POST["status_bank"];
	$pin_bank = $_POST["pin_bank"];
	$device = $_POST["device"];
	$password_true = $_POST["password_true"];
	$no_true = $_POST["no_true"];
	$otp_true = $_POST["otp_true"];
	$id_kbank = $_POST["id_kbank"];
	$token_kbank = $_POST["token_kbank"];
	$user_kbank = $_POST["user_kbank"];
	$pass_kbank = $_POST["pass_kbank"];
	
	
// 	//ฟังก์ชั่นวันที่
//   date_default_timezone_set('Asia/Bangkok');
// 	$date = date("Ymd");	
// //ฟังก์ชั่นสุ่มตัวเลข
//          $numrand = (mt_rand());
// //เพิ่มไฟล์
// $upload=$_FILES['fileupload_bank'];
// if($upload <> '') {   //not select file
// //โฟลเดอร์ที่จะ upload file เข้าไป 
// $path="../slip/";  
 
// //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
//  $type = strrchr($_FILES['fileupload_bank']['name'],".");
	
// //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
// $newname = $date.$numrand.$type;
// $path_copy=$path.$newname;
// $path_link="../slip/".$newname;
 
// //คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
// move_uploaded_file($_FILES['fileupload_bank']['tmp_name'],$path_copy);  	
//	}
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE bank SET  
			name_bank='$name_bank' ,
			bankacc_bank='$bankacc_bank' , 
			status_bank='$status_bank' ,
			bankfor='$bankfor' ,
			nameacc_bank='$nameacc_bank' ,
			pin_bank='$pin_bank' ,
			password_true='$password_true' ,
			no_true='$no_true' ,
			otp_true='$otp_true' ,
			token_kbank='$token_kbank' ,
			user_kbank='$user_kbank' ,
			id_kbank='$id_kbank' ,
			pass_kbank='$pass_kbank' ,
			device='$device'
			WHERE id='$id' ";
 
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($con); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'bank.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'bank.php'; ";
	echo "</script>";
}
?>