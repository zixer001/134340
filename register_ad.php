<?php
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
	//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม
	$username_ad = $_POST["username_ad"];
	$password_ad = md5($_POST["password_ad"]);
	$phone_ad = $_POST["phone_ad"];
	$status_ad = $_POST["status_ad"];
	$name_ad = $_POST["name_ad"];
	

	//เช็คซ้ำ
 $check = "
 SELECT  username_ad 
FROM admin  
WHERE username_ad = '$username_ad' 
 ";
   $result1 = mysqli_query($con, $check) or die(mysqli_error());
    $num=mysqli_num_rows($result1);
 
     if($num > 0)
     {
    echo "<script>";
    echo "alert(' ยูสเซอร์เนมนี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
     echo "window.location = 'login.php'; ";
   echo "</script>";
     }else{

    //เช็คซ้ำ
	$check = "
	SELECT  phone_ad 
	FROM admin
	WHERE phone_ad = '$phone_ad' 
	";
    $result1 = mysqli_query($con, $check) or die(mysqli_error());
    $num=mysqli_num_rows($result1);
 
    if($num > 0)
    {
    echo "<script>";
    echo "alert(' เบอร์โทรศัพท์นี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
    echo "window.location = 'login.php'; ";
    echo "</script>";
    }else{

    

    //เช็คซ้ำ
	$check = "
	SELECT  name_ad 
	FROM admin  
	WHERE name_ad = '$name_ad' 
	";
    $result1 = mysqli_query($con, $check) or die(mysqli_error());
    $num=mysqli_num_rows($result1);
 
    if($num > 0)
    {
    echo "<script>";
    echo "alert(' ชื่อ-นามสกุลนี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
    echo "window.location = 'login.php'; ";
    echo "</script>";
    }else{

    





	//เพิ่มเข้าไปในฐานข้อมูล
	$sql = "INSERT INTO admin (username_ad, password_ad, phone_ad, status_ad, name_ad)
			 VALUES('$username_ad', '$password_ad', '$phone_ad', '$status_ad','$name_ad')";

	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
}}}
	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('เพิ่มแอดมินสำเร็จ');";
	echo "window.location = 'staff.php'; ";
	echo "</script>";
	}
	else{
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to register again');";
	echo "</script>";
}
?>