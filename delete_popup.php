<?php
include ('../connectdb.php');
$id_popup = $_REQUEST["id_popup"];

//ลบข้อมูลออกจาก database ตาม id ที่ส่งมา

$sql = "DELETE FROM popup WHERE id_popup='$id_popup' ";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('delete Succesfuly');";
	echo "window.location = 'promotionpopup.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to delete again');";
	echo "</script>";
}
?>