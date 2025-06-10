
<?php
include ('../connectdb.php');
$id_mb = $_REQUEST["id_mb"];

//ลบข้อมูลออกจาก database ตาม id_mb ที่ส่งมา

$sql = "DELETE FROM member WHERE id_mb='$id_mb' ";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('delete Succesfuly');";
	echo "window.location = 'member.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to delete again');";
	echo "</script>";
}
?>