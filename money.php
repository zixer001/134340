<?php
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี


//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม
	
	$id_bank = $_POST["id_bank"];
	$money_bank = $_POST["money_bank"];
	$money_bank2 = $_POST["money_bank2"];
	
	$sql = "INSERT INTO bank (id_bank, money_bank, money_bank2)
			 VALUES('$id_bank', '$money_bank', '$money_bank2')";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('แก้ไขสำเร็จ');";
	echo "window.location = 'bank.php'; ";
	echo "</script>";
	}
	else{
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to withdraw again');";
	echo "</script>";
}
?>