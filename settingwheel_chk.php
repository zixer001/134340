<?php
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
	//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม
	
    $reward1 = $_POST["reward1"];
    $reward2 = $_POST["reward2"];
    $reward3 = $_POST["reward3"];
    $reward4 = $_POST["reward4"];
    $reward5 = $_POST["reward5"];
    $reward6 = $_POST["reward6"];
    $reward7 = $_POST["reward7"];
    $reward8 = $_POST["reward8"];
    $Change1 = $_POST["Change1"];
    $Change2 = $_POST["Change2"];
    $Change3 = $_POST["Change3"];
    $Change4 = $_POST["Change4"];
    $Change5 = $_POST["Change5"]; 
	$Change6 = $_POST["Change6"];
	$Change7 = $_POST["Change7"];
	$Change8 = $_POST["Change8"];
    $Image1 = $_POST["Image1"];
    $Image2 = $_POST["Image2"];
    $Image3 = $_POST["Image3"];
    $Image4 = $_POST["Image4"];
    $Image5 = $_POST["Image5"]; 
    $Image6 = $_POST["Image6"];
    $Image7 = $_POST["Image7"];
    $Image8 = $_POST["Image8"];
    $dp_creditspin = $_POST["dp_creditspin"];
    $change_point = $_POST["change_point"];

	
	
	
$sql = "UPDATE setting SET  
            reward1='$reward1' , 
            reward2='$reward2' ,
            reward3='$reward3' ,
            reward4='$reward4' ,
            reward5='$reward5' ,
            reward6='$reward6' ,
            reward7='$reward7' ,
            reward8='$reward8' ,
            Change1='$Change1' ,
            Change2='$Change2' ,
            Change3='$Change3' ,
            Change4='$Change4' ,
            Change5='$Change5' ,
            Change6='$Change6' ,
            Change7='$Change7' ,
            Change8='$Change8' ,
            Image1='$Image1' ,
            Image2='$Image2' ,
            Image3='$Image3' ,
            Image4='$Image4' ,
            Image5='$Image5' ,
            Image6='$Image6' ,
            Image7='$Image7' ,
            Image8='$Image8' ,
            dp_creditspin='$dp_creditspin' ,
            change_point= '$change_point'
            WHERE id=1 ";









	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('แก้ไขเว็ปไซด์เรียบร้อย');";
	echo "window.location = 'settingwheel.php'; ";
	echo "</script>";
	}
	else{
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to deposit again');";
	echo "</script>";
}
?>