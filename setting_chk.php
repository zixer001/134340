<?php
include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
	//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม
	
  $name_web = $_POST["name_web"];
  $link_web = $_POST["link_web"];
  $link_aff = $_POST["link_aff"];
  $logo_web = $_POST["logo_web"];
  $pic_web = $_POST["pic_web"];
  $slide_1 = $_POST["slide_1"];
  $slide_2 = $_POST["slide_2"];
  $lineoa = $_POST["lineoa"];
  $lineregister = $_POST["lineregister"];
  $linedeposit = $_POST["linedeposit"];
  $linewithdraw = $_POST["linewithdraw"];
  $cashback = $_POST["cashback"];
  $affcashback = $_POST["affcashback"]; 
	$agent = $_POST["agent"];
	$agent_link = $_POST["agent_link"];
	$set_dp = $_POST["set_dp"];
	$set_wd = $_POST["set_wd"];
	$rules = $_POST["rules"];
	$pass_agent = $_POST["pass_agent"];
	$txtTotal = $_POST["txtTotal"];
	$status_auto = $_POST["status_auto"];
	$max_autowd = $_POST["max_autowd"];
	$status_auto2 = $_POST["status_auto2"];
    $pic_user = $_POST["pic_user"];
 
	
$sql = "UPDATE setting SET  
            name_web='$name_web' , 
            logo_web='$logo_web' ,
            pic_web= '$pic_web' ,
            slide_1='$slide_1' ,
            slide_2='$slide_2' ,
            lineoa='$lineoa' ,
            lineregister='$lineregister' ,
            linedeposit = '$linedeposit' ,
            linewithdraw = '$linewithdraw' ,
            cashback = '$cashback' ,
            affcashback='$affcashback' ,
            link_web='$link_web' ,
            agent= '$agent' ,
            agent_link = '$agent_link' ,
            link_aff= '$link_aff' ,
            rules = '$rules' ,
            set_dp = '$set_dp' ,
            set_wd='$set_wd' ,
            pass_agent='$pass_agent' ,
            txtTotal= '$txtTotal' ,
            status_auto = '$status_auto' ,
            status_auto2 = '$status_auto2' ,
            pic_user = '$pic_user' ,
            max_autowd= '$max_autowd'
            WHERE id=1 ";









	$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('แก้ไขเว็ปไซด์เรียบร้อย');";
	echo "window.location = 'setting.php'; ";
	echo "</script>";
	}
	else{
 	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to deposit again');";
	echo "</script>";
}
?>