<?php
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
	//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม

	$transfer_in_true = $_POST["transfer_in_true"];
	$transfer_out_true = $_POST["transfer_out_true"];
	
	

	


	//เพิ่มเข้าไปในฐานข้อมูล
	$sql = "INSERT INTO transfer (transfer_in_true, transfer_out_true)
			 VALUES('$transfer_in_true', '$transfer_out_true')";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('เพิ่มรายการสำเร็จ');";
	echo "window.location = 'manual.php'; ";
	echo "</script>";
	}
	else{
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to register again');";
	echo "</script>";
}
?>